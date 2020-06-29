
class Product {
    constructor(id, name, votes, description, photo, price) {
        this._id = id;
        this._name = name;
        this._votes = votes;
        this._description = description;
        this._photo = photo;
        this._price = price;
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
export default Product;