import React, { useState } from "react"
import FavoriteIcon from '@material-ui/icons/Favorite';
const ProductFavorite = ({ product }) => {
    const [counterdishes, setCounterdishes] = useState(product.votes)
    const handleClickHeart = () => {
        setCounterdishes(counterdishes + 1)
        product.votes = counterdishes + 1
        console.log(product.votes)
    }
    return (<div className="heart">
        <strong>
            {counterdishes}
        </strong>
        <FavoriteIcon className="icon" onClick={handleClickHeart} />
    </div>)
}
export default ProductFavorite;