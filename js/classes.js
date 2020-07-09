/* This JS file with have all needed classes for the fronted */

/*************************************************************/

/* This class will allow manapulate Product objects */
/* Product Class Begin */
class Product {
    /* This special function (constructor) will create a product object from id, name, price, unit and quantity */
    constructor(id, name, price, unit, quantity){
        this.id = id;
        this.name = name;
        this.price = price;
        this.unit = unit;
        this.quantity = quantity;
    }
    /* This function will return the id */
    getId(){
        return this.id;
    }
    /* This function will return the name */
    getName(){
        return this.name;
    }
    /* This function will return the price */
    getPrice(){
        return formatPrice(this.price);
    }
    /* This function will return the unit */
    getUnit(){
        return this.unit;
    }
    /* This function will return the quantity */
    getQuantity(){
        return this.quantity;
    }
}
/* Product Class End */

/*************************************************************/

/* This class will allow manapulate Rating objects */
/* Rating Class Begin */
class Rating {
    /* This special function (constructor) will create a rating object from rate, username and date */
    constructor(rate, username, date){
        this.rate = rate;
        this.username = username;
        this.date = date;
    }
    /* This function will return the rate */
    getRate(){
        return this.rate;
    }
    /* This function will return the username */
    getUsername(){
        return this.username;
    }
    /* This function will return the date */
    getDate(){
        return this.date;
    }
}
/* Rating Class End */

/*************************************************************/

/* This class will allow manapulate Shipping Method objects */
/* Shipping Class Begin */
class Shipping {
    /* This special function (constructor) will create a shipping method object from id, name and price */
    constructor(id, name, price){
        this.id = id;
        this.name = name;
        this.price = price;
    }
    /* This function will return the id */
    getId(){
        return this.id;
    }
    /* This function will return the name */
    getName(){
        return this.name;
    }
    /* This function will return the price */
    getPrice(){
        return this.price;
    }
}
/* Shipping Class End */

/*************************************************************/

/* This class will allow manapulate Order objects */
/* Order Class Begin */
class Order {
    /* This special function (constructor) will create a shipping method object from id, name and price */
    constructor(id, date, shipping, totalPrice, status){
        this.id = id;
        this.date = date;
        this.shipping = shipping;
        this.totalPrice = totalPrice;
        this.status = status;
    }
    /* This function will return the id */
    getId(){
        return this.id;
    }
    /* This function will return the date */
    getDate(){
        return this.date;
    }
    /* This function will return the shipping */
    getShipping(){
        return this.shipping;
    }
    /* This function will return the totalPrice */
    getTotalPrice(){
        return this.totalPrice;
    }
    /* This function will return the status */
    getStatus(){
        return this.status;
    }
}
/* Shipping Class End */
/*************************************************************/