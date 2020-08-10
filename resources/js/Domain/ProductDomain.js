
class ProductDomain {
    constructor(id, name, votes, description, photo, price, partner) {
        this._id = id;
        this._name = name;
        this._votes = votes;
        this._description = description;
        this._photo = photo;
        this._price = price;
        this._partner = partner;
        this._quantity = 1;
    }
    get quantity() {
        return this._quantity;
    }
    delete() {

        this._quantity = 1;

    }
    incrementQuantity() {
        this._quantity++;
    }
    set quantity(quantity) {
        this._quantity = quantity;
    }
    get partner() {
        return this._partner;
    }

    get photo() {
        return this._photo;
    }
    get description() {
        return this._description;
    }
    get id() {
        return this._id
    }
    set votes(votes) {
        this._votes = votes;
    }
    get name() {
        return this._name
    }
    get votes() {
        return this._votes
    }
    get price() {
        return this._price;
    }
}
export default ProductDomain;