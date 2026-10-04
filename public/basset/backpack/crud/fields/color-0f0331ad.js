function bpFieldInitColorElement(element) {
    let inputText = element[0];
    let inputColor = inputText.nextElementSibling.querySelector('input');

    // Ensure color input has a valid value (HTML5 requires #rrggbb format)
    if (!inputColor.value || !inputColor.value.match(/^#[0-9a-f]{6}$/i)) {
        inputColor.value = '#000000';
    }
    
    // Ensure text input matches color input
    if (!inputText.value || !inputText.value.match(/^#[0-9a-f]{6}$/i)) {
        inputText.value = inputColor.value;
    }

    inputText.addEventListener('input', () => inputText.value = inputColor.value = '#' + inputText.value.replace(/[^\da-f]/gi, '').toLowerCase());
    inputColor.addEventListener('input', () => inputText.value = inputColor.value);
}

    