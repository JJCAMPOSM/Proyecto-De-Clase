-- Script de inicialización y normalización de la Base de Datos

-- 1. Tabla de roles
CREATE TABLE IF NOT EXISTS roles (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Insertar roles iniciales
INSERT INTO roles (nombre) VALUES 
('Administrador'),
('Cliente Externo'),
('Personal Interno');

-- 2. Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    rol_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuario_rol FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE RESTRICT
);

-- 3. Tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT
);

-- 4. Tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id SERIAL PRIMARY KEY,
    categoria_id INT NOT NULL,
    sku VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    marca VARCHAR(100),
    precio DECIMAL(10, 2) NOT NULL CHECK (precio >= 0),
    activo BOOLEAN DEFAULT TRUE,
    CONSTRAINT fk_producto_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT
);

-- 5. Tabla de inventario (Relación 1 a 1 con producto)
CREATE TABLE IF NOT EXISTS inventario (
    id SERIAL PRIMARY KEY,
    producto_id INT NOT NULL UNIQUE,
    stock_actual INT NOT NULL DEFAULT 0 CHECK (stock_actual >= 0),
    stock_minimo INT NOT NULL DEFAULT 0 CHECK (stock_minimo >= 0),
    ultima_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_inventario_producto FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- 6. Tabla de órdenes
CREATE TABLE IF NOT EXISTS ordenes (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo_cliente VARCHAR(50) NOT NULL, -- Ej. 'Externo' o 'Interno'
    estado VARCHAR(50) NOT NULL DEFAULT 'Pendiente', -- Ej. Pendiente, En Proceso, Enviado, Entregado, Cancelado
    total DECIMAL(10, 2) NOT NULL DEFAULT 0 CHECK (total >= 0),
    direccion_envio TEXT,
    notas TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_orden_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT
);

-- 7. Tabla de detalles de orden
CREATE TABLE IF NOT EXISTS orden_detalles (
    id SERIAL PRIMARY KEY,
    orden_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL CHECK (cantidad > 0),
    precio_unitario DECIMAL(10, 2) NOT NULL CHECK (precio_unitario >= 0),
    subtotal DECIMAL(10, 2) NOT NULL CHECK (subtotal >= 0),
    CONSTRAINT fk_detalle_orden FOREIGN KEY (orden_id) REFERENCES ordenes(id) ON DELETE CASCADE,
    CONSTRAINT fk_detalle_producto FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT
);

-- 8. Tabla de logs de movimientos
CREATE TABLE IF NOT EXISTS logs_movimientos (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL,
    accion VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_log_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT
);
