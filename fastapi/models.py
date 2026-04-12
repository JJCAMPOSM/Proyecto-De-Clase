from sqlalchemy import Boolean, Column, ForeignKey, Integer, String, Text, Numeric, TIMESTAMP
from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
from database import Base

class Role(Base):
    __tablename__ = "roles"
    id = Column(Integer, primary_key=True, index=True)
    nombre = Column(String(50), unique=True, nullable=False)

class Usuario(Base):
    __tablename__ = "usuarios"
    id = Column(Integer, primary_key=True, index=True)
    rol_id = Column(Integer, ForeignKey("roles.id"), nullable=False)
    nombre = Column(String(100), nullable=False)
    apellidos = Column(String(100), nullable=False)
    telefono = Column(String(20))
    email = Column(String(150), unique=True, nullable=False)
    password_hash = Column(String(255), nullable=False)
    activo = Column(Boolean, default=True)
    creado_en = Column(TIMESTAMP, server_default=func.now())
    
    rol = relationship("Role")

class Categoria(Base):
    __tablename__ = "categorias"
    id = Column(Integer, primary_key=True, index=True)
    nombre = Column(String(100), unique=True, nullable=False)
    descripcion = Column(Text)

class Producto(Base):
    __tablename__ = "productos"
    id = Column(Integer, primary_key=True, index=True)
    categoria_id = Column(Integer, ForeignKey("categorias.id"), nullable=False)
    sku = Column(String(50), unique=True, nullable=False)
    nombre = Column(String(150), nullable=False)
    descripcion = Column(Text)
    marca = Column(String(100))
    precio = Column(Numeric(10, 2), nullable=False)
    activo = Column(Boolean, default=True)
    
    categoria = relationship("Categoria")
    inventario = relationship("Inventario", back_populates="producto", uselist=False)

class Inventario(Base):
    __tablename__ = "inventario"
    id = Column(Integer, primary_key=True, index=True)
    producto_id = Column(Integer, ForeignKey("productos.id", ondelete="CASCADE"), unique=True, nullable=False)
    stock_actual = Column(Integer, nullable=False, default=0)
    stock_minimo = Column(Integer, nullable=False, default=0)
    ultima_actualizacion = Column(TIMESTAMP, server_default=func.now(), onupdate=func.now())
    
    producto = relationship("Producto", back_populates="inventario")

class Orden(Base):
    __tablename__ = "ordenes"
    id = Column(Integer, primary_key=True, index=True)
    usuario_id = Column(Integer, ForeignKey("usuarios.id"), nullable=False)
    tipo_cliente = Column(String(50), nullable=False)
    estado = Column(String(50), nullable=False, default='Pendiente')
    total = Column(Numeric(10, 2), nullable=False, default=0)
    direccion_envio = Column(Text)
    notas = Column(Text)
    creado_en = Column(TIMESTAMP, server_default=func.now())
    
    detalles = relationship("OrdenDetalle", back_populates="orden")
    usuario = relationship("Usuario")

class OrdenDetalle(Base):
    __tablename__ = "orden_detalles"
    id = Column(Integer, primary_key=True, index=True)
    orden_id = Column(Integer, ForeignKey("ordenes.id", ondelete="CASCADE"), nullable=False)
    producto_id = Column(Integer, ForeignKey("productos.id"), nullable=False)
    cantidad = Column(Integer, nullable=False)
    precio_unitario = Column(Numeric(10, 2), nullable=False)
    subtotal = Column(Numeric(10, 2), nullable=False)
    
    orden = relationship("Orden", back_populates="detalles")
    producto = relationship("Producto")

class LogMovimiento(Base):
    __tablename__ = "logs_movimientos"
    id = Column(Integer, primary_key=True, index=True)
    usuario_id = Column(Integer, ForeignKey("usuarios.id"), nullable=False)
    accion = Column(String(100), nullable=False)
    descripcion = Column(Text)
    fecha = Column(TIMESTAMP, server_default=func.now())
    
    usuario = relationship("Usuario")
