from database import SessionLocal
import models
from utils import get_password_hash

ADMIN_EMAIL = "admin@macuin.com"
ADMIN_PASSWORD = "admin123"
ADMIN_NAME = "Admin"
ADMIN_LASTNAME = "Macuin"

ROLE_NAMES = ["Administrador", "Cliente Externo", "Personal Interno"]


def ensure_roles(db):
    existing_roles = {role.nombre: role for role in db.query(models.Role).all()}
    for role_name in ROLE_NAMES:
        if role_name not in existing_roles:
            role = models.Role(nombre=role_name)
            db.add(role)
    db.commit()


def get_role_id(db, role_name):
    role = db.query(models.Role).filter(models.Role.nombre == role_name).first()
    return role.id if role else None


def create_admin_user():
    db = SessionLocal()
    try:
        ensure_roles(db)
        admin_role_id = get_role_id(db, "Administrador")
        if admin_role_id is None:
            print("No se pudo encontrar el rol Administrador.")
            return

        existing = db.query(models.Usuario).filter(models.Usuario.email == ADMIN_EMAIL).first()
        if existing:
            print(f"El usuario administrador ya existe: {ADMIN_EMAIL}")
            return

        admin_user = models.Usuario(
            rol_id=admin_role_id,
            nombre=ADMIN_NAME,
            apellidos=ADMIN_LASTNAME,
            email=ADMIN_EMAIL,
            telefono="5551234567",
            password_hash=get_password_hash(ADMIN_PASSWORD),
            activo=True,
        )
        db.add(admin_user)
        db.commit()
        print(f"Administrador creado con éxito: {ADMIN_EMAIL} / {ADMIN_PASSWORD}")
    except Exception as e:
        print("Error al crear usuario administrador:", e)
    finally:
        db.close()


if __name__ == "__main__":
    create_admin_user()
