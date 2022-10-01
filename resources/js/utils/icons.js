const icons = {
    app: 'bi bi-app',
    appIndicator: 'bi bi-app-indicator',
    arrowLeft: 'bi bi-arrow-left',
    arrowRight: 'bi bi-arrow-right',

    check: 'bi bi-check',
    checkLg: 'bi bi-check-lg',
    checkCircleFill: 'bi bi-check-circle-fill',
    collection: 'bi bi-collection',
    collectionPlay: 'bi bi-collection-play',

    exclamationCircleFill: 'bi bi-exclamation-circle-fill',

    infoCircleFill: 'bi bi-info-circle-fill',
    images: 'bi bi-images',

    listRight: 'bi bi-filter-right',
    listLeft: 'bi bi-filter-left',
    login: 'bi bi-box-arrow-right',
    logout: 'bi bi-box-arrow-left',
    load: 'bi bi-arrow-clockwise',
    loading: 'bi bi-arrow-clockwise animation-rotate-z',

    home: 'bi bi-house',

    pencilSquare: 'bi bi-pencil-square',
    pieChart: 'bi bi-pie-chart',
    plus: 'bi bi-plus',
    plusLg: 'bi bi-plus-lg',

    search: 'bi bi-search',

    trash: 'bi bi-trash',

    video: 'bi bi-play-btn',

    user: 'bi bi-person',
    users: 'bi bi-people',
    userX: 'bi bi-person-x',
    userCheck: 'bi bi-person-check',
    userPlus: 'bi bi-person-plus',
    userCircle: 'bi bi-person-circle',
    userPlus: 'bi bi-person-plus',
    userMinus: 'bi bi-person-dash',

    x: 'bi bi-x',
    xLg: 'bi bi-x-lg',
};

export default {
    icons,
    get(name) {
        return icons[name] ?? '';
    }
};