import React, { useEffect, useState } from "react";
import { FileService } from "../../Services/FileService";
import Spinner from "../Spinner/Spinner"
import PropTypes from "prop-types";
import axios from "../../Config/axiosconfig";
const ImgPreview = ({ fileName, directory, heightSpinner = "100%", widthSpinner = "100%", ...props }) => {
    const [loadingFetchImg, setLoadingFetchImg] = useState(true)
    const [file, setFile] = useState(null);
    useEffect(() => {
        const cancelToken = axios.CancelToken;
        const source = cancelToken.source();
        async function fetchImgApi() {
            try {
                if (fileName == "") {
                    fileName = "notImg.png"
                    directory = "NotImg";
                }
                const file = (await FileService.findId(fileName, directory)).data
                setFile(URL.createObjectURL(file))
                setLoadingFetchImg(false)
            } catch (error) {
                if (axios.isCancel(error)) {
                    console.log("Cancelled")
                } else {
                    throw error
                }
            }


        }
        fetchImgApi();
        return () => {
            source.cancel();
        };
    }, [])

    return (loadingFetchImg ? <Spinner type="Oval" color="#f7681c" height={heightSpinner} width={widthSpinner} className="spinner primary" /> : < img src={file} {...props} />);

}
ImgPreview.propTypes = {
    fileName: PropTypes.string.isRequired,
    directory: PropTypes.string.isRequired

}

export default ImgPreview;