

const transformPhotos = (photos) => {

    return photos.map((photo) => transformPhotoSaved(photo.name))
}
const transformPhotoSaved = (photoName) => {
    return { source: photoName, options: { type: "local" } }
}

const productUtil = { transformPhotos, transformPhotoSaved };
export default productUtil;