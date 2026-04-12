from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
import models
from database import engine

from routers import auth, users, orders, reports, products

# models.Base.metadata.create_all(bind=engine)

app = FastAPI(title="MACUIN Autopartes API", description="Central API Gateway", version="1.0.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/")
def read_root():
    return {"message": "MACUIN Autopartes API is running."}

app.include_router(auth.router, prefix="/api/auth", tags=["auth"])
app.include_router(users.router, prefix="/api/users", tags=["users"])
app.include_router(orders.router, prefix="/api/orders", tags=["orders"])
app.include_router(reports.router, prefix="/api/reports", tags=["reports"])
app.include_router(products.router, prefix="/api/products", tags=["products"])
