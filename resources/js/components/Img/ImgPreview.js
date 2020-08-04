import React, { useEffect, useState } from "react";
import { FileService } from "../../Services/FileService";
import Spinner from "../Spinner/Spinner"
import PropTypes from "prop-types";

const ImgPreview = ({ fileName, directory, heightSpinner = "100%", widthSpinner = "100%", ...props }) => {
    const [loadingFetchImg, setLoadingFetchImg] = useState(true)
    const [file, setFile] = useState(null);
    useEffect(() => {
        async function fetchImgApi() {
            if (fileName == "") {
                fileName = "notImg.png"
                directory = "NotImg";
            }
            const file = (await FileService.findId(fileName, directory)).data
            setFile(URL.createObjectURL(file))
            setLoadingFetchImg(false)
        }
        fetchImgApi();
    }, [])

    return (loadingFetchImg ? <Spinner type="Oval" color="#f7681c" height={heightSpinner} width={widthSpinner} className="spinner primary" /> : < img src={file} {...props} />);

}
ImgPreview.propTypes = {
    fileName: PropTypes.string.isRequired,
    directory: PropTypes.string.isRequired

}

export default ImgPreview;