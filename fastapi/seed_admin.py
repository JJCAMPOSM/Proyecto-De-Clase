from database import SessionLocal
import models
from utils import get_password_hash

def seed_users():
    db = SessionLocal()
    try:
        # Check if users already exist
        if db.query(models.Usuario).first() is not None:
            print("Users already seeded.")
            return

        # Insert generic admin (Rol 1)
        admin = models.Usuario(
            rol_id=1,
            nombre="Admin",
            apellidos="Macuin",
            email="admin@macuin.com",
            telefono="5551234567",
            password_hash=get_password_hash("admin123")
        )
        # Insert generic client (Rol 2)
        client = models.Usuario(
            rol_id=2, # Cliente Externo
            nombre="Cliente",
            apellidos="Prueba",
            email="cliente@correo.com",
            telefono="5559876543",
            password_hash=get_password_hash("cliente123")
        )
        
        # Insert dummy category and product to test order functionality
        cat = models.Categoria(nombre="Accesorios", descripcion="Accesorios para auto")
        db.add(cat)
        db.commit()
        
        prod = models.Producto(
            categoria_id=cat.id,
            sku="ACC-001",
            nombre="Cubrevolante de Piel",
            descripcion="El mejor.",
            marca="Sparco",
            precio=499.00
        )
        db.add(prod)
        db.commit()
        
        inv = models.Inventario(producto_id=prod.id, stock_actual=50, stock_minimo=5)
        db.add(inv)

        db.add(admin)
        db.add(client)
        db.commit()
        print("Successfully seeded users and base products.")
    finally:
        db.close()

if __name__ == "__main__":
    seed_users()
