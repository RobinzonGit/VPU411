function bpFieldInitRangeElement($element) {
    const input = $element[0];
    const bubble = input.nextElementSibling;
    if (!bubble || !bubble.classList.contains('bp-range-bubble')) return;

    // native range thumb is ~16px wide; offset the bubble so it tracks the thumb center
    const THUMB_WIDTH = 16;

    function positionBubble() {
        bubble.textContent = input.value;
        const min = parseFloat(input.min) || 0;
        const max = parseFloat(input.max) || 100;
        const val = parseFloat(input.value) || 0;
        const ratio = max === min ? 0 : (val - min) / (max - min);
        const offset = ratio * (input.offsetWidth - THUMB_WIDTH) + THUMB_WIDTH / 2;
        bubble.style.left = offset + 'px';
    }

    input.addEventListener('input', positionBubble);
    window.addEventListener('resize', positionBubble);
    // defer to next frame so layout is settled (e.g. inside tabs/modals)
    requestAnimationFrame(positionBubble);
}

