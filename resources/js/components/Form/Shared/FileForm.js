import React, { useState } from "react";
import { FilePond, File, registerPlugin } from 'react-filepond'
import 'filepond/dist/filepond.min.css'
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css'
import PropTypes from 'prop-types';
import { load } from "react-cookies";
import { FileService } from "../../../Services/FileService";

registerPlugin(FilePondPluginImageExifOrientation, FilePondPluginImagePreview)
const pathName = window.location.origin
console.log(window.location)
const FileForm = ({ filesParameter, isMultiple, messageUser, form, field, directory }) => {
    const [files, setFiles] = useState(filesParameter);
    const handleUpdateFiles = (files) => {
        /*         const filesMap = files.map((fileItem) => fileItem.file);
         */

        let fileNotSave = files.filter((file) => file.serverId == null).map((fileFilter) => fileFilter.file)
        let fileOrFiles = fileNotSave;
        if (!isMultiple) {
            fileOrFiles = fileNotSave[0];
        }
        console.log(fileNotSave, "fileOr", fileOrFiles)
        if (Array.isArray(fileOrFiles)) {
            form.setFieldValue(field.name, { files: fileOrFiles })

        } else {
            form.setFieldValue(field.name, { file: fileOrFiles || {} })

        }
        setFiles(files)
    }
    const onAddFile = (error, file) => {
        console.log(file, error, "id", form.values.id)

    }
    const onLoadFile = async (source, load, error, progress, abort, headers) => {
        /* fetch(`/api/files/find?load=${source}`).then(res => res.blob()).then(load) */
        let file = (await FileService.findId(source, directory)).data
        load(file)
    }
    const onRemoveFile = (source, load, error) => {
        console.log("se removio", source)
        error("no se pudo borrar :/");
        load();
    }
    return (
        <FilePond files={files} instantUpload={false} iconProcess="" onaddfile={onAddFile} server={{ load: onLoadFile, remove: onRemoveFile }} allowMultiple={isMultiple} onupdatefiles={handleUpdateFiles} labelIdle={messageUser} />

    )

}
FileForm.propTypes = {
    filesParameter: PropTypes.array,
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