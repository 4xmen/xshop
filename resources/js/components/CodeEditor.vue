
<template>
    <div id="code-editor">
        <div class="editor-toolbar">
            <label for="editor-syntax">Syntax</label>

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

import { basicEditor } from "prism-code-editor/setups";

import "prism-code-editor/prism/languages/markup";
import "prism-code-editor/prism/languages/json";
import "prism-code-editor/prism/languages/javascript";
import "prism-code-editor/prism/languages/css";

export default {
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
    gap: 8px;
    width: 100%;
    min-width: 0;
}

.editor-toolbar {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
}

.editor-toolbar label {
    color: #a1a1aa;
    font-size: 13px;
}

.syntax-select {
    padding: 6px 10px;
    color: #e4e4e7;
    background: #18181b;
    border: 1px solid #3f3f46;
    border-radius: 6px;
    font-size: 13px;
}

.editor-container {
    display: grid;
    width: 100%;
    min-width: 0;
    min-height: 240px;
    overflow: hidden;
    border: 1px solid #3f3f46;
    border-radius: 8px;
    background: #0d1117;
}

.editor-container :deep(.prism-code-editor) {
    min-height: 240px;
    font-size: 14px;
    line-height: 1.6;
}
.editor-container {
    white-space: pre;
}
</style>
