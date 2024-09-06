// нормальная цена
document.querySelectorAll(".discounted-Price")?.forEach(value => {
    value.innerHTML = "$"+((Number)(value.innerHTML)).toFixed(2);
})