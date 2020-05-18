let tel = prompt("Введите номер телефона, содржащий знак \"\/\"");
let sign = prompt("Введите знак, на который заменить знак \"\/\"");

alert(`Модифицированный номер телефона:\n${modifyNumber(tel, sign)}`);

function modifyNumber(tel, sign) {
    return tel.replace(new RegExp(/\//g), sign);
}
