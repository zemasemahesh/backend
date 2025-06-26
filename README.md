Run the Project by following command:
php -S localhost:8000
-----------------------------------------------------
**Create api:**
http://localhost:8000/api.php
Method : POST
Fields:
{
  "name": "Admin",
  "email": "admin@admin.com",
  "password": "Admin@123",
  "dob": "1995-08-20"
}
-------------------------------------------------
**Read Api**
http://localhost:8000/api.php
Method : GET
-------------------------------------------------
**Get by single user**
http://localhost:8000/api.php?id=1
Method:GET
-------------------------------------------------
**UPDATE Api**
http://localhost:8000/api.php?id=1
Method:PUT
Fields:
{
  "name": "Admin",
  "email": "admin@admin.com",
  "password": "Admin@123",
  "dob": "1995-08-20"
}
-------------------------------------------------
**Delete Api**
http://localhost:8000/api.php?id=1
Method:DELETE
------------------------------------------------
