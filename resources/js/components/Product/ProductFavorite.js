import React, { useState } from "react"
import FavoriteIcon from '@material-ui/icons/Favorite';
import { ProductService } from "../../Services/ProductService";
const ProductFavorite = ({ product }) => {
    const [counterdishes, setCounterdishes] = useState(product.votes)
    const handleClickHeart = async () => {
        await ProductService.incrementCounterFavoriteFindProduct(product.id)
        setCounterdishes(counterdishes + 1)
        product.votes = counterdishes + 1
    }

    return (<div className="heart">
        <strong>
            {counterdishes}
        </strong>
        <FavoriteIcon className="icon" onClick={handleClickHeart} />
    </div>)
}
export default ProductFavorite;