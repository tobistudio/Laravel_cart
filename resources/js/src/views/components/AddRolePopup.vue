<template>
    <div class="popup">
        <div class="popup-overlay" @click="closePopup"></div>
        <div class="popup-content-wrapper">
            <div class="popup-content" @click.prevent.stop>
                <div class="popup-header">
                    <div class="title">Add Role</div>
                    <div class="close" @click="closePopup">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path fill="currentColor" d="m16.192 6.344l-4.243 4.242l-4.242-4.242l-1.414 1.414L10.535 12l-4.242 4.242l1.414 1.414l4.242-4.242l4.243 4.242l1.414-1.414L13.364 12l4.242-4.242z"></path></svg>
                    </div>
                </div>
                <div class="popup-content">
                    <div v-if="error_message" class="error-message">{{ error_message }}</div>

                    <div :class="['input-wrapper name', localName ? 'has-content' : '', name_validation ? 'error' : '', nameClassFocus]">
                        <div class="label">{{ trans.name }}</div>
                        <div class="label-floating">{{ trans.name }}</div>
                        <input v-model="localName" type="email" @focus="nameFocus" @blur="nameBlur"/>
                        <span class="error" v-if="name_validation">{{ name_validation }}</span>
                    </div>

                    <div class="actions">
                        <button class="primary" @click="saveRole" :disabled="!validateForm">{{ trans.save }}</button>
                        <button class="secondary" @click="closePopup">{{ trans.cancel }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            localName: '',
            nameClassFocus: false,
            name_validation: null,

            error_message: null,

            trans: {
                name: 'Name',
                save: 'Save',
                cancel: 'Cancel',
                message: {
                    name_required: 'Name is required',
                }
            }
        }
    },
    computed: {
        validateForm() {
            return this.localName !== '';
        },
    },
    methods: {
        nameFocus() {
            this.nameClassFocus = 'focus';
        },
        nameBlur() {
            this.nameClassFocus = false;
        },
        saveRole() {
            let payload = {
                name: this.localName,
            };

            this.$store.dispatch('saveRole', payload).then((data) => {
                this.$store.state.error_message = false;
                this.$store.state.success_message = data.message;
                this.$store.state.message_type = data.message_type ? data.message_type : 'system';

                this.$emit('roleSaved', data);
            }).catch(res => {
                if (res.errors) {
                    this.name_validation = res.errors.name ? this.trans.message[res.errors.name[0]] : null;
                } else {
                    this.error_message = res.message ? this.trans.message[res.message]: null;
                }
            });
        },
        closePopup() {
            this.$emit('closePopup');
        }
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
    .popup {
        align-items: center;
        justify-content: center;
        margin: auto;
        border-radius: inherit;
        display: flex;
        left: 0;
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        z-index: 2;

        .popup-overlay {
            border-radius: inherit;
            bottom: 0;
            left: 0;
            opacity: 1;
            position: fixed;
            right: 0;
            top: 0;
            background: rgba(var(--popup-background-color),var(--opacity-point-six));
            z-index: 2;
        }

        .popup-content-wrapper {
            max-height: calc(100% - 48px);
            width: 800px;
            max-width: calc(100% - 48px);
            margin: 24px;
            display: flex;
            flex-direction: column;
            border-radius: 6px;
            z-index: 2;

            .popup-content {
                display: flex;
                flex-direction: column;
                overflow-y: auto;
                box-shadow: 0 8px 10px -5px rgba(var(--popup-background-color), var(--opacity-point-zero-six)),0 16px 24px 2px rgba(var(--popup-background-color), var(--opacity-point-zero-four)),0 6px 30px 5px rgba(var(--popup-background-color), var(--opacity-point-zero-two));
                background: rgb(var(--accent-color));
                color: rgba(var(--secondary-color),var(--opacity-point-six));
                min-height: 100px;
                border-radius: 6px;

                .popup-header {
                    padding: 20px 20px 12px 20px;
                    position: relative;
                    border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));

                    .title {
                        font-size: 1.25rem;
                        line-height: 1.6;
                        font-weight: 500;
                        letter-spacing: .0094rem;
                        text-overflow: ellipsis;
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                    }

                    .close {
                        position: absolute;
                        z-index: 2;
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        top: 0.9375rem;
                        right: 0.9375rem;
                        width: 34px;
                        height: 34px;
                        align-items: center;
                        display: flex;
                        transition: transform,opacity .2s cubic-bezier(.4,0,.2,1);
                        grid-area: content;
                        justify-content: center;
                        white-space: nowrap;
                        cursor: pointer;
                        border-radius: 50%;

                        svg {
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            font-size: 24px;
                            height: 24px;
                            width: 24px;
                        }

                        &:hover {
                            background: rgba(var(--icon-hover-background-color));
                        }
                    }
                }

                .popup-content {
                    padding: 12px 20px 20px 20px;

                    > .error-message {
                        padding: 13.5px;
                        background: rgba(var(--red-color), var(--opacity-point-one-two));
                        border-radius: 6px;
                        color: rgba(var(--red-color));
                        margin-bottom: 20px;
                    }

                    .input-wrapper-container {
                        display: flex;
                        flex-direction: row;
                    }

                    .input-wrapper {
                        grid-area: field;
                        position: relative;
                        align-items: flex-start;
                        display: flex;
                        cursor: text;
                        font-size: 16px;
                        letter-spacing: .009375em;
                        padding: 12px 0;
                        opacity: 1;
                        flex-direction: column;

                        .label {
                            visibility: visible;
                            contain: layout paint;
                            margin-inline-start: 16px;
                            margin-inline-end: 16px;
                            max-width: calc(100% - 16px - 16px);
                            pointer-events: none;
                            position: absolute;
                            top: 20px;
                            transform-origin: left center;
                            transition: .15s cubic-bezier(.4,0,.2,1);
                            transition-property: all;
                            transition-property: opacity,transform;
                            color: rgba(var(--secondary-color));
                        }

                        .label-floating {
                            visibility: hidden;
                            transform: translateY(-50%);
                            margin: 0 4px;
                            font-size: 0.75em;
                            left: 10px;
                            position: absolute;
                            z-index: 999;
                            background: #fff;
                            padding: 0 10px;
                            font-weight: 600;
                            background: rgba(var(--accent-color));
                            color: rgba(var(--secondary-color), var(--opacity-point-six));
                        }

                        input {
                            color: #000;
                            opacity: 0.6;
                            flex: 1;
                            transition: .15s opacity cubic-bezier(.4,0,.2,1);
                            min-width: 0;
                            display: flex;
                            flex-wrap: wrap;
                            letter-spacing: .009375em;
                            min-height: 40px;
                            max-height: 40px;
                            padding-inline-start: 16px;
                            padding-inline-end: 16px;
                            padding-top: 5px;
                            padding-bottom: 6px;
                            width: 100%;
                            border-radius: 6px;
                            border: 1px solid rgba(var(--secondary-color), var(--opacity-point-six));
                            font-size: 16px;
                            background: rgba(var(--accent-color));
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                            &:focus-visible {
                                outline: unset;
                            }
                        }

                        &.has-content {
                            .label {
                                visibility: hidden;
                            }

                            .label-floating {
                                visibility: visible;
                            }
                        }

                        &.error {
                            input {
                                border-color: rgba(var(--primary-color));
                            }

                            .label {
                                color: rgba(var(--primary-color));
                            }

                            .label-floating {
                                color: rgba(var(--primary-color));
                            }
                        }

                        &.focus {
                            .label {
                                visibility: hidden;
                            }

                            .label-floating {
                                visibility: visible;
                                color: rgba(var(--primary-color));
                            }

                            input {
                                border: 2px solid rgba(var(--primary-color));
                                padding-inline-start: 15px;
                            }
                        }

                        img {
                            cursor: pointer;
                            opacity: 0.6;
                            width: 24px;
                            position: absolute;
                            top: 28px;
                            right: 16px;
                        }

                        span.error {
                            color: rgba(var(--primary-color));
                            align-items: flex-end;
                            display: flex;
                            font-size: .75rem;
                            font-weight: 400;
                            letter-spacing: .0333333333em;
                            line-height: normal;
                            min-height: 22px;
                            overflow: hidden;
                            justify-content: space-between;
                            padding: 3px 14px 0 14px;
                        }
                    }

                    .actions {
                        border: 0;
                        flex-direction: row;
                        padding: 0;
                        align-items: center;
                        align-self: center;
                        display: flex;
                        width: 100%;
                        margin-top: 20px;

                        button {
                            width: 50%;
                            border-radius: 4px;
                            cursor: pointer;
                            line-height: 23px;
                            outline: 0;
                            padding: 8px;
                            transition: all .2s ease-in-out;
                            text-transform: uppercase;
                            font-weight: 600;
                            font-size: 16px;

                            &:hover {
                                opacity: var(--opacity-point-eight-seven);
                            }

                            &:disabled {
                                opacity: var(--opacity-point-six);
                            }

                            &.primary {
                                background: rgba(var(--primary-button-background-color));
                                border: 1px solid rgba(var(--primary-button-background-color));
                                color: rgba(var(--primary-button-color));
                                margin-right: 10px;
                            }

                            &.secondary {
                                background: rgba(var(--secondary-button-background-color));
                                border: 1px solid rgba(var(--secondary-button-background-color));
                                color: rgba(var(--secondary-button-color));
                                margin-left: 10px;
                            }
                        }
                    }
                }
            }
        }
    }
</style>
