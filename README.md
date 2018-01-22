 ## Города 
    все: /cities
    метод: get
 ## Категории
    все: /sections
    метод: get
 ## Slider
    адрес: /slider?city_id={1}
    метод: get
 ## Shops
    все по ID города: /shops?city_id={1}
    все по Id города и по ID раздела: /shops/section?city_id={1}&section_id={13}
    метод: get
 ## Products
    все продукты города и раздела: products/section?city_id={1}&section_id={13}
    все продукты города и магазина: products/shop?city_id={1}&shop_id={2}
    все продукты города, раздела и магазина: products/shop-section?city_id={1}&section_id={13}&shop_id={2}
 ## Регистрация
    url: /sign-up
    method: POST
    format: JSON
  ```json
    {
        "username": "Sultan",
        "email": "osult@mail.ru",
        "phone": "87079662796",
        "password": "Maint112233",
        "address": "Tole-bi Kunaeva"
    }
  ```
    response:
   ```json
    {
        "status": "Зарегистрирован",
        "auth_key": "ciylRarG6Z3XI_gM_CwqXkah6ZIC2t0m"
    }
  ```
 ## Логин
    url: /login
    method: POST
    format: JSON
  ```json
    {
    	"email": "osult@mail.rul",
    	"password": "Maint112233"
    }
  ```
 ## Оформление заказа
     url: /order
     method: POST
     format: JSON
   ```json
     {
     	"auth_key": "HeQz4WUmy-TXiMWm3-r84uoGu1-Sovmk",
     	"address": "Kunaeva Gogolya",
     	"description": "Privezite pojaluista mejdu 14:00 i 16:00",
     	"products": [
     		{
     			"product_id": "32",
     			"product_price": "1500",
     			"product_count": "3",
     			"product_parameters": {}
     		},
     		{
     			"product_id": "32",
     			"product_price": "1500",
     			"product_count": "3",
     			"product_parameters": {
     				"size": "27",
     				"color": "#ccffcc"
     			}
     		},
     		{
     			"product_id": "32",
     			"product_price": "1000",
     			"product_count": "2",
     			"product_parameters": {
     				"size": "30"
     			}
     		}
     	]
     }
   ```
 ## Редактирование личных данных пользователя
    url: /user-info/change
    method: POST
    format: JSON
   ```json
     {
     	"auth_key": "HeQz4WUmy-TXiMWm3-r84uoGu1-Sovmk",
     	"username": "Omashev Sultan",
     	"phone": "87079613400",
     	"old_password": "Maint112233",
     	"new_password": "Maint11",
     	"city_id": 1
     }
   ```