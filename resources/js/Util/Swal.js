import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'
const MySwal = withReactContent(Swal)

export function messageSuccess(message = "¡Operacion exitosa!") {
    return MySwal.fire({
        text: message,
        customClass: { content: "notification swal" },
        toast: true,
        position: "top-right",
        showConfirmButton: false,
        padding: "1.2rem",
        timer: 2500,
        background: "#388e3c"
    })
}
export function messageSuccessTransaction(code) {
    return MySwal.fire({
        html: `¡Operacion exitosa! codigo: <a href=/buys/?item=${code}>${code}</a>`,
        position: "center"
    })
}
export function messageError(message) {
    return MySwal.fire({
        text: message,
        showConfirmButton: true,
        position: "center",
        confirmButtonText: "Entendido",

    })
}
export function successSaveBusiness() {
    return MySwal.fire({
        text: "¡Genial, se activaron nuevas opciones para que pueda administrar sus negocios!",
        showConfirmButton: true,
        position: "center",
        confirmButtonText: "Entendido",

    })
}
