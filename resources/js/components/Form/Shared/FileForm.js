import React, { useState } from "react";
import { FilePond, File, registerPlugin } from 'react-filepond'
import 'filepond/dist/filepond.min.css'
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css'
import PropTypes from 'prop-types';
import { FileService } from "../../../Services/FileService";

registerPlugin(FilePondPluginImageExifOrientation, FilePondPluginImagePreview)
const FileForm = ({ filesParameter, isMultiple, messageUser, form, field, directory, onRemoveFileObject }) => {
    console.log("files", filesParameter)
    const [files, setFiles] = useState(isMultiple ? filesParameter : Object.keys(filesParameter[0]).length == 0 ? [] : [filesParameter[0]]);
    /* const [files, setFiles] = useState([{ source: "polleria.jpg", options: { type: "local" } }]); */
    const handleUpdateFiles = (files) => {
        let fileNotSave = files.filter((file) => file.origin == 1 || file.origin == 3).map((fileFilter) => fileFilter.file)
        console.log("file not saved", fileNotSave)
        let fileOrFiles = !isMultiple ? fileNotSave[0] : fileNotSave;

        if (Array.isArray(fileOrFiles)) {
            form.setFieldValue(field.name, fileOrFiles)
        } else {
            form.setFieldValue(field.name, [fileOrFiles || {}])
        }
        setFiles(files)
    }
    const onLoadFile = async (source, load, error, progress, abort) => {
        console.log("fileForm", source, "directory" + directory)
        let file = (await FileService.findId(source, directory)).data
        load(file)
    }
    const onRemoveFile = (source, load, error) => {
        console.log("se removio", source)
        error("no se pudo borrar :/");
        load();
        onRemoveFileObject(form.values.id);
    }
    return (
        <FilePond files={files} instantUpload={false} server={{ url: "./", load: onLoadFile, remove: onRemoveFile }} onupdatefiles={handleUpdateFiles} allowMultiple={isMultiple} labelIdle={messageUser} />

    )

}
FileForm.propTypes = {
    onRemoveFileObject: PropTypes.func.isRequired,
    isMultiple: PropTypes.bool,
    messageUser: PropTypes.string,
    directory: PropTypes.string.isRequired
}
FileForm.defaultProps = {
    filesParameter: [],
    isMultipe: false,
    messageUser: "Arrastra una imagen"
}
export default FileForm;