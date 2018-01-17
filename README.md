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