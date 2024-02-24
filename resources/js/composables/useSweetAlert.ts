import {getCurrentInstance} from 'vue'

interface OptionsAlert {
    text: string
    title: string
    icon: string
    confirmButtonText?: string
    html?: string
    iconColor?: string
    animation?: boolean
    footer?: any
    backdrop?: boolean
    toast?: boolean
    target?: string
    input?: string // text, email etc..
    width?: string
    color?: string // hex
    position?: 'top' | 'top-start' | 'top-end' | 'center' | 'center-start' | 'center-end' | 'bottom' | 'bottom-start' | 'bottom-end'
    grow?: boolean
    customClass?: string
    timer?: string
    timerProgressBar?: boolean
    heightAuto?: boolean
    allowOutsideClick?: boolean
    allowEscapeKey?: boolean
    allowEnterKey?: boolean
    stopKeydownPropagation?: boolean
    keydownListenerCapture?: boolean
    showConfirmButton?: boolean
    showDenyButton?: boolean
    showCancelButton?: boolean
    denyButtonText?: string
    cancelButtonText?: string
    confirmButtonColor?: string
    denyButtonColor?: string
    cancelButtonColor?: string // hex
    // add more if is necessary...
}

export function useSweetAlert() {
    const app = getCurrentInstance()?.appContext.app

    function showAlert(options: OptionsAlert) {
        // @ts-expect-error ...
        app.config.globalProperties.$swal(options)
    }

    return {
        showAlert
    }
}
