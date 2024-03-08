from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

class Admin(db.Model):
    __tablename__ = 'tbl_admin'
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(25), nullable=False)
    password = db.Column(db.String(100), nullable=False)

class MenuItem(db.Model):
    __tablename__ = 'tbl_menuitem'
    itemID = db.Column(db.Integer, primary_key=True)
    menuID = db.Column(db.Integer, db.ForeignKey('tbl_menu.menuID'), nullable=False)
    menuItemName = db.Column(db.Text, nullable=False)
    price = db.Column(db.DECIMAL(15, 2), nullable=False)

    def serialize(self):
        return {
            'itemID': self.itemID,
            'menuID': self.menuID,
            'menuItemName': self.menuItemName,
            'price': float(self.price)
        }

class Menu(db.Model):
    __tablename__ = 'tbl_menu'
    menuID = db.Column(db.Integer, primary_key=True)
    menuName = db.Column(db.String(25), nullable=False)
    items = db.relationship('MenuItem', backref='menu', lazy=True)

    def serialize(self):
        return {
            'menuID': self.menuID,
            'menuName': self.menuName,
            'items': [item.serialize() for item in self.items]  # Serializar los elementos del menú
        }


class Mesa(db.Model):
    __tablename__ = 'tbl_mesa'
    mesaID = db.Column(db.Integer, primary_key=True)

class Order(db.Model):
    __tablename__ = 'tbl_order'
    orderID = db.Column(db.Integer, primary_key=True)
    status = db.Column(db.Text, nullable=False)
    total = db.Column(db.DECIMAL(15, 2), nullable=False)
    order_date = db.Column(db.Date, nullable=False)
    mesaID = db.Column(db.Integer, db.ForeignKey('tbl_mesa.mesaID'), nullable=False)

class OrderDetail(db.Model):
    __tablename__ = 'tbl_orderdetail'
    orderDetailID = db.Column(db.Integer, primary_key=True)
    orderID = db.Column(db.Integer, db.ForeignKey('tbl_order.orderID'), nullable=False)
    itemID = db.Column(db.Integer, db.ForeignKey('tbl_menuitem.itemID'), nullable=False)
    quantity = db.Column(db.Integer, nullable=False)
    mesaID = db.Column(db.Integer, db.ForeignKey('tbl_mesa.mesaID'), nullable=False)

class Staff(db.Model):
    __tablename__ = 'tbl_staff'
    staffID = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(25), nullable=False)
    password = db.Column(db.String(100), nullable=False)
    status = db.Column(db.Text, nullable=False)
    role = db.Column(db.Text, nullable=False)
