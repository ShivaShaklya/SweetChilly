function tshirt_type(type,event){
    let buttons = document.querySelectorAll('.design-button');
    buttons.forEach(button => button.classList.remove('active-button'));
    event.currentTarget.classList.add('active-button');
    window.location.href = type + ".php?selected=" + type;
}