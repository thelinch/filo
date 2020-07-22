import React, { Component } from 'react';
import PropTypes from 'prop-types';
// import { Button, ButtonToolbar, Modal } from 'reactstrap';
import classNames from 'classnames';
import ModalComponent from 'react-modal';
import { Close, ThumbUpAltOutlined, FlagOutlined, HighlightOff, ColorizeOutlined, InfoOutlined } from '@material-ui/icons'

class Modal extends Component {

  // toggle() {
  //   this.setState({
  //     modal: !this.state.modal,
  //   });
  // }

  render() {
    const {
            show, color, children, title, header, onCancel, onClose,
            onOptional, onConfirm, showCancelButton, showCloseButton, showOptionalButton,
            textCancel, textConfirm, textOptional
    } = this.props;
    let Icon;

    switch (color) {
      case 'primary':
        Icon = <ColorizeOutlined className="modal__title-icon" />;
        break;
      case 'success':
        Icon = <ThumbUpAltOutlined className="modal__title-icon" />;
        break;
      case 'warning':
        Icon = <FlagOutlined className="modal__title-icon" />;
        break;
      case 'danger':
        Icon = <HighlightOff className="modal__title-icon" />;
        break;
      case 'info':
        Icon = <InfoOutlined className="modal__title-icon" />;
        break;
      default:
        break;
    }
    const modalClass = classNames({
      'modal-dialog--header': header,
    });

    return (
      <>
        {/* <Button color={color} onClick={this.toggle}>{button}</Button> */}
        <ModalComponent
          isOpen={show}
          onRequestClose={onClose}
          className={`modal-dialog--${color} ${modalClass}`}
          ariaHideApp={false}
          overlayClassName="modal-overlay"
          contentLabel="Modal"
        >
          <div className="modal-content">
            <div className="modal__header">
              { showCloseButton && <Close className="modal__close-button" fontSize="small" onClick={onClose}/> }
              {/* <button className="lnr lnr-cross modal__close-button" onClick={this.toggle} /> */}
              {header ? '' : Icon}
              <h4 className="bold-text  modal__title">{title}</h4>
            </div>
            <div className="modal__body">
              {children}
            </div>
            {
              !header &&
                <div className="modal__footer">
                  <button className={`button button-${color}`} onClick={onConfirm}>{textConfirm}</button>
                  { showOptionalButton && <button className={`button button-primary`} onClick={onOptional}>{textOptional ? textOpcional : 'Opcional'}</button>}
                  { showCancelButton && <button className={`button`} onClick={onCancel}>{textCancel ? textCancel : 'Cancelar'}</button>}
                </div>
            }
          </div>
        </ModalComponent>
      </>
    );
  }
}
Modal.propTypes = {
    title: PropTypes.string,
    // message: PropTypes.string,
    color: PropTypes.string.isRequired,
    header: PropTypes.bool,
    showCancelButton: PropTypes.bool,
    showCloseButton: PropTypes.bool,
    showOptionalButton: PropTypes.bool,
    // custom option
    show: PropTypes.bool.isRequired,
    onCancel: PropTypes.func,
    onConfirm: PropTypes.func,
    onClose: PropTypes.func,
    onOptional: PropTypes.func,
    // text button
    textConfirm: PropTypes.string,
    textCancel: PropTypes.string,
    textOptional: PropTypes.string,
}
Modal.defaultProps = {
    title: '',
    // message: '',
    header: false,
    showCancelButton: false,
    showCloseButton: true,
    showOptionalButton: false,
    textConfirm: "Confirmar",
    // custom option
    show: false
}
export default Modal;