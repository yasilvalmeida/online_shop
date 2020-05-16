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
        return this.price;
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