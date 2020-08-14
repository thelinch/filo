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

