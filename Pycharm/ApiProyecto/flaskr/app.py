from flask import Flask, jsonify, request, redirect, url_for, render_template
from flaskr.modelos import db, MenuItem, Menu, Order, OrderDetail, Staff, Mesa, Admin
from flaskr import create_app

app = create_app('default')
app_context = app.app_context()
app_context.push()

db.init_app(app)
db.create_all()

@app.route('/login', methods=['POST'])
def login():
    data = request.json
    username = data.get('username')
    password = data.get('password')

    user = Staff.query.filter_by(username=username).first()

    if user is None:
        admin = Admin.query.filter_by(username=username).first()

        if admin and admin.password == password:
            return redirect(url_for('admin_dashboard'))
        else:
            return jsonify({"error": "Credenciales de inicio de sesión incorrectas"}), 401
    else:
        role = user.role.lower()
        if role == 'chef':
            return redirect(url_for('chef_dashboard'))
        elif role == 'mesero':
            return redirect(url_for('mesero_dashboard'))
        else:
            return jsonify({"error": "Rol de usuario no válido"}), 401

@app.route('/admin_dashboard')
def admin_dashboard():
    return jsonify({"message": "Bienvenido al panel de control del administrador"})

@app.route('/chef_dashboard')
def chef_dashboard():
    return jsonify({"message": "Bienvenido al panel de control del chef"})

@app.route('/mesero_dashboard')
def mesero_dashboard():
    return jsonify({"message": "Bienvenido al panel de control del mesero"})

@app.route('/menu/<int:menu_id>')
def menu_items(menu_id):
    menu = Menu.query.filter_by(menuID=menu_id).first()
    if menu:
        menu_items = MenuItem.query.filter_by(menuID=menu_id).all()
        serialized_menu = menu.serialize()
        return jsonify({"menu": serialized_menu, "menu_items": [item.serialize() for item in menu_items]})
    else:
        return 'Categoría no encontrada'


if __name__ == '__main__':
    app.run(debug=True)
