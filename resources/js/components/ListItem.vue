<template>
    <div class="d-flex flex-column flex-sm-row mb-2 list-item">
        <div class="d-flex py-2">
            <div v-if="theCover" class="d-none d-sm-block list-item-cover">
                <img :class="theCoverStyle" :src="theCover" :alt="theTitle">
            </div>
            <div class="d-flex flex-column ms-2 list-item-info">
                <h5 class="mb-0 fs-6 fw-semibold">{{ theTitle }}</h5>
                <p class="mb-0 text-muted">{{ theSubtitle }}</p>
                <div class="d-flex flex-wrap">
                    <slot name="badges" />
                </div>
            </div>
        </div>
        <div
            class="d-flex justify-content-center align-items-center py-2 ms-sm-auto list-item-actions">
            <slot name="actions" />
        </div>
    </div>
</template>

<script>

export default {
    components: {},

    props: {
        item: { type: Object, default: null },

        title: { type: String, default: null },
        subtitle: { type: String, default: null },
        cover: { type: String, default: null },
        coverStyle: { type: String, default: null },
    },

    computed: {
        theCoverStyle() {
            let style = this.item?.coverStyle ?? this.coverStyle ?? 'rectangle';
            return `img-fluid ${style}`;
        },
        theCover() {
            return this.item?.cover ?? this.cover;
        },
        theTitle() {
            return this.item?.title ?? this.title;
        },
        theSubtitle() {
            return this.item?.subtitle ?? this.subtitle;
        },
    }
};
</script>

<style>
.list-item {
    background-color: transparent;
}

.list-item-cover {
    overflow: hidden;
}

.list-item-cover>img.square {
    width: 60px;
    height: 60px;
}

.list-item-cover>img.circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
}

.list-item-cover>img.rectangle {
    width: 100px;
    height: 60px;
}

.list-item-info {
    background-color: transparent;
}

.list-item-actions {
    background-color: transparent;
}
</style>