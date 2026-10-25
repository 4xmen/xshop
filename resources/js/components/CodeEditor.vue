<template>
    <div id="code-editor">
        <div class="editor-toolbar">

            <div class="btn reset" @click="resetText">
                Reset
            </div>

            <div v-for="(btn, iBtn) in btns">
                <div class="btn" :title="btn.value" @click="replaceKeyword(iBtn)">
                    {{ btn.title }}
                </div>
            </div>

            <div>
                <label for="editor-syntax">Syntax</label>

                &nbsp;
                &nbsp;
                <select
                    id="editor-syntax"
                    v-model="syntax"
                    class="syntax-select"
                >
                    <option value="html">HTML</option>
                    <option value="json">JSON</option>
                    <option value="javascript">JavaScript</option>
                    <option value="css">CSS</option>
                </select>
            </div>

        </div>

        <div ref="editorContainer" class="editor-container"></div>

        <textarea
            v-if="xname"
            :name="xname"
            :value="currentValue"
            :disabled="disabled"
            hidden
        ></textarea>
    </div>
</template>

<script>


function decodeBase64Utf8(encoded) {
    const bytes = Uint8Array.from(atob(encoded), char => char.charCodeAt(0));
    return new TextDecoder().decode(bytes);
}

import {basicEditor} from "prism-code-editor/setups";

import "prism-code-editor/prism/languages/markup";
import "prism-code-editor/prism/languages/json";
import "prism-code-editor/prism/languages/javascript";
import "prism-code-editor/prism/languages/css";

export default {

    methods: {
        resetText(){

            if (!confirm("Are you sure to reset the code?")){
                return;
            }
            this.currentValue = this.firstData;

            this.editor.setOptions({value: this.firstData});

            this.$emit("input", this.firstData);
            this.$emit("change", this.firstData);
        },
        replaceKeyword(keyword_input) {
            const textarea = this.editor.textarea;

            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;

            const keyword = `%${keyword_input}%`


            const value = this.editor.value;
            const newValue =
                value.substring(0, start) +
                keyword +
                value.substring(end);

            this.editor.setOptions({value: newValue});

            this.currentValue = newValue;

            this.$emit("input", newValue);
            this.$emit("change", newValue);

            textarea.focus();

            const cursor = start + keyword.length;
            textarea.setSelectionRange(cursor, cursor);
        }
    },
    name: "CodeEditor",

    props: {
        value: {
            type: String,
            default: ""
        },

        xname: {
            type: String,
            required: true
        },
        btns: {
            type: Array,
            default: [],
        },

        defaultSyntax: {
            type: String,
            default: "html",
            validator(value) {
                return [
                    "html",
                    "json",
                    "javascript",
                    "css"
                ].includes(value);
            }
        },

        disabled: {
            type: Boolean,
            default: false
        }
    },

    emits: ["input", "change", "syntax-change"],

    data() {
        return {
            editor: null,
            syntax: this.defaultSyntax,
            currentValue: decodeBase64Utf8(this.value),
            firstData: decodeBase64Utf8(this.value),
        };
    },


    mounted() {
        this.editor = basicEditor(
            this.$refs.editorContainer,
            {
                value: this.currentValue,
                language: this.syntax,
                theme: "github-dark",
                readOnly: this.disabled
            }
        );

        // Use the editor's actual textarea for native form submission.
        this.editor.textarea.name = this.name;

        // Keep the component value synchronized with user input.
        this.editor.textarea.addEventListener("input", () => {
            this.currentValue = this.editor.value;

            this.$emit("input", this.currentValue);
            this.$emit("change", this.currentValue);
        });
    },

    watch: {


        value(newValue) {
            if (newValue === this.currentValue) return;

            this.currentValue = newValue;

            if (this.editor) {
                this.editor.setOptions({
                    value: newValue
                });
            }
        },

        syntax(newSyntax) {
            if (!this.editor) return;

            this.editor.setOptions({
                language: newSyntax
            });

            this.$emit("syntax-change", newSyntax);
        },

        disabled(newValue) {
            if (!this.editor) return;

            this.editor.setOptions({
                readOnly: newValue
            });
        }
    },

    beforeUnmount() {
        if (this.editor) {
            this.editor.remove();
            this.editor = null;
        }
    }
};
</script>

<style scoped>
#code-editor {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-xs);
    inline-size: 100%;
    min-inline-size: 0;
    direction: ltr;
}

.editor-toolbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: var(--spacing-2xs);
    padding-block-start: var(--spacing-2xs);
}

.editor-toolbar label {
    color: var(--color-text-muted);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
}

.editor-toolbar .btn {
    --bs-btn-bg: transparent;
    --bs-btn-color: var(--color-text);
    --bs-btn-border-color: var(--color-border-strong);
    --bs-btn-hover-bg: var(--color-hover);
    --bs-btn-hover-color: var(--color-text);
    --bs-btn-hover-border-color: var(--color-text-muted);
    --bs-btn-active-bg: var(--color-hover);
    --bs-btn-active-color: var(--color-text);
    --bs-btn-active-border-color: var(--color-text-muted);
    --bs-btn-padding-x: var(--spacing-sm);
    --bs-btn-font-size: var(--font-size-xs);

    min-block-size: var(--control-height-xs);
}

.editor-toolbar .reset {
    --bs-btn-bg: var(--color-danger-subtle);
    --bs-btn-color: var(--color-danger-text);
    --bs-btn-border-color: transparent;
    --bs-btn-hover-bg: var(--color-danger-subtle);
    --bs-btn-hover-color: var(--color-danger-text);
    --bs-btn-hover-border-color: var(--color-danger-text);
    --bs-btn-active-bg: var(--color-danger-subtle);
    --bs-btn-active-color: var(--color-danger-text);
    --bs-btn-active-border-color: var(--color-danger-text);
}

.syntax-select {
    min-block-size: var(--control-height-xs);
    padding-block: 0;
    padding-inline: var(--spacing-sm);
    border: 1px solid var(--color-border-strong);
    border-radius: var(--radius-md);
    background-color: var(--color-field);
    color: var(--color-text);
    font-size: var(--font-size-xs);
}

.syntax-select:hover {
    border-color: var(--color-text-muted);
}

.syntax-select:focus {
    border-color: var(--color-focus-ring);
    box-shadow: 0 0 0 1px var(--color-focus-ring);
    outline: none;
}

.editor-container {
    display: grid;
    inline-size: 100%;
    min-inline-size: 0;
    min-block-size: 240px;
    overflow: hidden;
    border: 1px solid var(--color-border-strong);
    border-radius: var(--radius-md);
    background-color: var(--color-field);
    white-space: pre;
}

.editor-container:focus-within {
    border-color: var(--color-focus-ring);
    box-shadow: 0 0 0 1px var(--color-focus-ring);
}

.editor-container :deep(.prism-code-editor) {
    min-block-size: 240px;
    font-size: var(--font-size-sm);
    line-height: 1.6;
}
</style>
