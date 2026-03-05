FROM python:3.11-slim

# Instalar dependencias de compilación para paquetes Python y PostgreSQL
RUN apt-get update && apt-get install -y \
    gcc \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Instalar dependencias básicas necesarias
RUN pip install --no-cache-dir Flask psycopg2-binary SQLAlchemy python-dotenv

# Mantenemos el contenedor en ejecución de manera básica.
# Si existiera una app Flask real lista, la iniciaríamos:
# CMD ["flask", "run", "--host=0.0.0.0", "--port=5000"]
# En modo inicial usamos un comando contenedor
CMD if [ -f app.py ]; then flask run --host=0.0.0.0 --port=5000; else echo "Por favor, crea tu app.py de Flask en este directorio."; tail -f /dev/null; fi
