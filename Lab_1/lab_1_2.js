let lab_1_2 = {

age: prompt("Сколько Вам лет?", 0),
year: prompt("Какой сейчас год?", ""),
msg: ""
}

while(lab_1_2.age > 0)
{
    lab_1_2.msg += `В ${--lab_1_2.year} Вам было ${--lab_1_2.age} лет.\n`;
}
alert(lab_1_2.msg);
