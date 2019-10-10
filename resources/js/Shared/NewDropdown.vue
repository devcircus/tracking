<template>
    <div class="relative">
        <button ref="trigger" type="button" class="elative" @click="toggle">
            <slot name="trigger" />
        </button>
        <div v-if="show">
            <div style="position: fixed; top: 0; right: 0; left: 0; bottom: 0; z-index: 90; background: black; opacity: .2" @click="close()" />
            <div ref="dropdown" :style="getStyles()" @click.stop>
                <slot name="dropdown" />
            </div>
        </div>
    </div>
</template>

<script>
import { mapValues } from 'lodash';

export default {
    props: {
        width: {
            type: String,
            default: '140px',
        },
        top: {
            type: String,
            default: '20',
        },
        right: {
            type: String,
            default: '10',
        },
        nav: {
            type: Boolean,
            default: false,
        },
    },
    data () {
        return {
            show: false,
        }
    },
    mounted () {
        document.addEventListener('keydown', (e) => {
            if (e.keyCode === 27) {
                this.close();
            }
        });
        this.$listen('dropdown-should-close', () => {
            this.close();
        });
        document.addEventListener('scroll', (e) => {
            let top = this.$refs.trigger.getBoundingClientRect().top;

            if (top < 175 && ! this.nav) {
                this.$refs.trigger.style.zIndex = 20;
            } else {
                this.$refs.trigger.style.zIndex = 70;
            }
        });
    },
    methods: {
        close () {
            this.show = false;
        },
        toggle () {
            this.show = !this.show;
        },
        getStyles () {
            let properties = {
                width: this.width,
                top: this.top,
                right: this.right,
            };

            let mutatedProperties = mapValues(properties, property => {
                if (property != '0' & ! property.endsWith('px')) {
                    return `${property}px`;
                }

                return property;
            });

            return `position: absolute; width:${mutatedProperties.width}; top:${mutatedProperties.top}; right:${mutatedProperties.right}; z-index: 9999;`;
        },
    },
}
</script>
