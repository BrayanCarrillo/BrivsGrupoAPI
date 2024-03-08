from flask import Flask

def create_app(config_name):
    app = Flask(__name__)
    app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://hola:1234@localhost/fosdb'
    app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
    return app
