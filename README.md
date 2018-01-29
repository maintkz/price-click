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
 ## Оценка товара
     url: /product-rating
     method: POST
     format: JSON
     ставить оценку можно только один раз на один товар
     rating_value = 1-5
   ```json
      {
      	"auth_key": "Dz4Y48D6eaVpOZQwAUjtna2fT1Jr7DlY",
      	"product_id": "42",
      	"rating_value": "5"
      }
   ```
 ## Оценка товара
      url: /shop-rating
      method: POST
      format: JSON
      ставить оценку можно только один раз одному магазину
      rating_value = 1-5
   ```json
       {
       	"auth_key": "Dz4Y48D6eaVpOZQwAUjtna2fT1Jr7DlY",
       	"shop_id": "3",
       	"rating_value": "5"
       }
   ```
 ## Список заказов
       url: /order-group-list
       method: POST
       format: JSON
  ```json
        {
        	"auth_key": "uBivVbSO9YiqEz83T6xBTpzAdiIIPiTN"
        }

  ```
 ## Список заказанных товаров
        url: /orders-list
        method: POST
        format: JSON
   ```json
        {
            "auth_key": "uBivVbSO9YiqEz83T6xBTpzAdiIIPiTN",
            "order_group_id": "14"
        }
   ```
 ## Просмотр купленного продукта
        url: /ordered-product
        method: POST
        format: JSON
   ```json
        {
        	"auth_key": "uBivVbSO9YiqEz83T6xBTpzAdiIIPiTN",
        	"order_id": 66
        }
   ```
  ## Структура категори и подкатегорий
          url: /categories/?section_id=23
          method: GET
  ## Пользовательское соглашение
          url: http://priceclick.kz/terms
          method: GET
  ## Продукты категории
          url: /products/category-products?category_id=15&city_id=1
          method: GET
  ## Продукты подкатегории
          url: /products/subcategory-products?subcategory_id=13&city_id=1
          method: GET
  ## Магазины категории
          url: /shops/category-shops?category_id=14&city_id=1
          method: GET
  ## Магазины подкатегории
          url: /shops/subcategory-shops?subcategory_id=24&city_id=1
          method: GET
  ## Shop Info
          url: /shops/shop-info?shop_id=3
          method: GET
  ## Search products
          url: /products/search?query=суп
          method: GET
  ## Поиски по магазинам во всех организациях
          url: /shops/search?query=зомания&city_id=1
          method: GET
  ## Поиски по магазинам по разделам
          url: /shops/search?query=зоомания&city_id=1&section_id=13
          method: GET
  ## Поиски по магазинам по подкатегориям
          url: /shops/search?query=букет&city_id=1&subcategory_id=24
          method: GET
  ## Поиски продуктов во всех разделам
          url: /products/search?query=суп&city_id=1
          method: GET
  ## Поиски продуктов по разделам
          url: /products/search?query=будка&city_id=1&section_id=13
          method: GET
  ## Поиски продуктов по подкатегориям
          url: /products/search?query=салат&city_id=1&subcategory_id=20
          method: GET