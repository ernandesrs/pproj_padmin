const icons = {
    app: 'bi bi-app',
    appIndicator: 'bi bi-app-indicator',

    check: 'bi bi-check',
    checkLg: 'bi bi-check-lg',
    checkCircleFill: 'bi bi-check-circle-fill',

    exclamationCircleFill: 'bi bi-exclamation-circle-fill',

    infoCircleFill: 'bi bi-info-circle-fill',

    listRight: 'bi bi-filter-right',
    listLeft: 'bi bi-filter-left',
    login: 'bi bi-box-arrow-right',
    logout: 'bi bi-box-arrow-left',

    home: 'bi bi-house',

    x: 'bi bi-x',
    xLg: 'bi bi-x-lg',
};

export default {
    icons,
    get(name) {
        return icons[name] ?? '';
    }
};