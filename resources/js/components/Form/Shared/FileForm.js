import React, { useState } from "react";
import { FilePond, File, registerPlugin } from 'react-filepond'
import 'filepond/dist/filepond.min.css'
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css'
import PropTypes from 'prop-types';

registerPlugin(FilePondPluginImageExifOrientation, FilePondPluginImagePreview)

const FileForm = ({ filesParameter, isMultiple, messageUser, form, field }) => {
    const [files, setFiles] = useState(filesParameter);
    const handleUpdateFiles = (files) => {
        console.log(field)
        setFiles(files)
    }
    return (
        <FilePond files={files} allowMultiple={isMultiple} onupdatefiles={handleUpdateFiles} labelIdle={messageUser} />

    )

}
FileForm.propTypes = {
    filesParameter: PropTypes.array,
    isMultiple: PropTypes.bool,
    messageUser: PropTypes.string
}
FileForm.defaultProps = {
    filesParameter: [],
    isMultipe: false,
    messageUser: "Arrastra una imagen"
}
export default FileForm;