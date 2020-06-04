alert(`Ваш браузер ${defineBrowser()}`);

function defineBrowser() {
    let answer = navigator.userAgent;

    if (answer.includes('Firefox')) {
        return 'Firefox';
    }

    if (answer.includes('OP')) {
        return 'Opera';
    }

    if (answer.includes('Chrome')) {
        return 'Chrome';
    }

    if (answer.includes('MSIE')) {
        return 'Internet Explorer';
    }

    return 'неизвестен';
}
