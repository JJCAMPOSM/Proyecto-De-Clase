import requests

try:
    print("Enviando request de login a la API...")
    # Usamos htt://localhost:8001 porque ese es el puerto expuesto de proyecto_api
    res = requests.post(
        'http://localhost:8001/api/auth/login', 
        json={'email': 'admin@macuin.com', 'password': 'admin123'},
        timeout=5
    )
    print(f"Status Final: {res.status_code}")
    print(f"Respuesta Final: {res.text}")
except Exception as e:
    print(f"Error en la petición: {e}")
