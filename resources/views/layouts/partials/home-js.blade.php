{{-- =====================================================
     BOOTSTRAP JS
====================================================== --}}
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

{{-- =====================================================
     JQUERY
====================================================== --}}
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
></script>

<script>
    /* =====================================================
       CUSTOM AI TOOLS DROPDOWN
    ===================================================== */

    document.addEventListener('DOMContentLoaded', function () {

        const dropdown =
            document.getElementById('aiToolsDropdown');

        const dropdownBtn =
            document.getElementById('aiToolsDropdownBtn');

        const dropdownMenu =
            document.getElementById('aiToolsDropdownMenu');

        const selectedToolsText =
            document.getElementById('selectedToolsText');

        if (
            !dropdown ||
            !dropdownBtn ||
            !dropdownMenu ||
            !selectedToolsText
        ) {
            return;
        }

        function updateSelectedTools() {

            const checkedTools =
                dropdownMenu.querySelectorAll(
                    'input[type="checkbox"]:checked'
                );

            if (checkedTools.length === 0) {

                selectedToolsText.textContent =
                    'Select AI Tools';

                selectedToolsText.classList.remove(
                    'has-selection'
                );

                return;
            }

            const selectedNames = [];

            checkedTools.forEach(function (checkbox) {

                const option =
                    checkbox.closest('.ai-tool-option');

                const name =
                    option
                        ? option.querySelector('.ai-tool-name')
                        : null;

                if (name) {
                    selectedNames.push(
                        name.textContent.trim()
                    );
                }
            });

            selectedToolsText.textContent =
                selectedNames.join(', ');

            selectedToolsText.classList.add(
                'has-selection'
            );
        }

        dropdownBtn.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

                dropdown.classList.toggle('open');
            }
        );

        const checkboxes =
            dropdownMenu.querySelectorAll(
                'input[type="checkbox"]'
            );

        checkboxes.forEach(function (checkbox) {

            checkbox.addEventListener(
                'change',
                updateSelectedTools
            );
        });

        document.addEventListener(
            'click',
            function (event) {

                if (!dropdown.contains(event.target)) {

                    dropdown.classList.remove('open');
                }
            }
        );

        updateSelectedTools();
    });


    /* =====================================================
       COPY PROMPT
    ===================================================== */

    function copyPrompt(
        elementId,
        btnElement,
        promptId
    ) {

        const element =
            document.getElementById(elementId);

        if (!element) {
            return;
        }

        const originalText =
            element.value;

        let scope =
            btnElement
                ? btnElement.closest('.modal')
                : null;

        if (!scope && btnElement) {
            scope =
                btnElement.closest('.prompt-card');
        }

        if (!scope) {
            scope = document;
        }

        const variableFields =
            scope.querySelectorAll(
                `.prompt-variable-input[data-prompt-id="${promptId}"]`
            );

        if (variableFields.length === 0) {

            copyTextToClipboard(
                originalText,
                btnElement,
                promptId
            );

            return;
        }

        const values = {};
        let firstEmptyField = null;

        variableFields.forEach(function (field) {

            const variableNumber =
                field.dataset.variable;

            const value =
                field.value.trim();

            values[variableNumber] =
                value;

            if (
                value === '' &&
                !firstEmptyField
            ) {
                firstEmptyField = field;
            }
        });

        if (firstEmptyField) {

            firstEmptyField.focus();

            const label =
                firstEmptyField
                    .closest('.prompt-variable-field')
                    ?.querySelector('.prompt-variable-label')
                    ?.textContent
                    ?.trim();

            showVariableToast(
                `Please fill ${label || 'Variable ' + firstEmptyField.dataset.variable}.`
            );

            return;
        }

        const textToCopy =
            originalText.replace(
                /\[([^\[\]]+)\]/g,
                function (match, variableToken) {

                    const key =
                        variableToken.trim();

                    return Object.prototype.hasOwnProperty.call(
                        values,
                        key
                    )
                        ? values[key]
                        : match;
                }
            );

        copyTextToClipboard(
            textToCopy,
            btnElement,
            promptId
        );
    }


    /* =====================================================
       CLIPBOARD HELPER
    ===================================================== */

    function copyTextToClipboard(
        text,
        btnElement,
        promptId
    ) {

        if (
            navigator.clipboard &&
            window.isSecureContext
        ) {

            navigator.clipboard
                .writeText(text)
                .then(function () {

                    showCopySuccess(
                        btnElement
                    );

                })
                .catch(function () {

                    fallbackCopyText(
                        text,
                        btnElement
                    );
                });

            return;
        }

        fallbackCopyText(
            text,
            btnElement
        );
    }


    /* =====================================================
       FALLBACK COPY
    ===================================================== */

    function fallbackCopyText(
        text,
        btnElement
    ) {

        const textarea =
            document.createElement('textarea');

        textarea.value =
            text;

        textarea.style.position =
            'fixed';

        textarea.style.opacity =
            '0';

        document.body.appendChild(
            textarea
        );

        textarea.select();

        try {

            document.execCommand(
                'copy'
            );

            showCopySuccess(
                btnElement
            );

        } catch (error) {

            console.error(
                'Copy failed:',
                error
            );
        }

        textarea.remove();
    }


    /* =====================================================
       COPY SUCCESS
    ===================================================== */

    function showCopySuccess(
        btnElement
    ) {

        if (!btnElement) {
            return;
        }

        const originalHTML =
            btnElement.innerHTML;

        btnElement.innerHTML =
            '<i class="bi bi-check2 me-1"></i> Copied!';

        setTimeout(function () {

            btnElement.innerHTML =
                originalHTML;

        }, 2000);
    }


    /* =====================================================
       SYNC VARIABLE INPUTS
    ===================================================== */

    document.addEventListener(
        'input',
        function (event) {

            const field =
                event.target.closest(
                    '.prompt-variable-input'
                );

            if (!field) {
                return;
            }

            const promptId =
                field.dataset.promptId;

            const variable =
                field.dataset.variable;

            const value =
                field.value;

            document
                .querySelectorAll(
                    `.prompt-variable-input[data-prompt-id="${promptId}"][data-variable="${variable}"]`
                )
                .forEach(function (otherField) {

                    if (otherField !== field) {

                        otherField.value =
                            value;
                    }
                });
        }
    );


    /* =====================================================
       RESET VARIABLES
    ===================================================== */

    function resetPromptVariables(
        promptId
    ) {

        document
            .querySelectorAll(
                `.prompt-variable-input[data-prompt-id="${promptId}"]`
            )
            .forEach(function (field) {

                field.value = '';
            });
    }


    /* =====================================================
       VARIABLE TOAST
    ===================================================== */

    function showVariableToast(
        message
    ) {

        const oldToast =
            document.getElementById(
                'promptVariableToast'
            );

        if (oldToast) {
            oldToast.remove();
        }

        const toast =
            document.createElement('div');

        toast.id =
            'promptVariableToast';

        toast.innerHTML = `
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <span>${message}</span>
        `;

        Object.assign(
            toast.style,
            {
                position: 'fixed',
                bottom: '25px',
                left: '50%',
                transform: 'translateX(-50%)',
                zIndex: '99999',
                background: '#111827',
                color: '#ffffff',
                padding: '12px 18px',
                borderRadius: '10px',
                boxShadow: '0 10px 30px rgba(0,0,0,0.20)',
                fontWeight: '600',
                fontSize: '13px',
                display: 'flex',
                alignItems: 'center'
            }
        );

        document.body.appendChild(
            toast
        );

        setTimeout(function () {

            if (toast) {
                toast.remove();
            }

        }, 2500);
    }


    /* =====================================================
       SHARE PROMPT
    ===================================================== */

    function sharePrompt(
        promptId,
        promptTitle
    ) {

        const shareUrl =
            `${window.location.origin}/prompts/${promptId}`;

        const shareData = {
            title:
                promptTitle,

            text:
                `Check out this AI Prompt: ${promptTitle}`,

            url:
                shareUrl
        };

        if (navigator.share) {

            navigator.share(
                shareData
            )
            .catch(function (error) {

                if (
                    error.name !==
                    'AbortError'
                ) {

                    console.error(
                        'Share failed:',
                        error
                    );
                }
            });

            return;
        }

        if (
            navigator.clipboard &&
            window.isSecureContext
        ) {

            navigator.clipboard
                .writeText(shareUrl)
                .then(function () {

                    showShareToast();

                })
                .catch(function () {

                    window.prompt(
                        'Copy this prompt link:',
                        shareUrl
                    );
                });

            return;
        }

        window.prompt(
            'Copy this prompt link:',
            shareUrl
        );
    }


    /* =====================================================
       SHARE TOAST
    ===================================================== */

    function showShareToast() {

        const oldToast =
            document.getElementById(
                'shareSuccessToast'
            );

        if (oldToast) {
            oldToast.remove();
        }

        const toast =
            document.createElement('div');

        toast.id =
            'shareSuccessToast';

        toast.innerHTML = `
            <i class="bi bi-check-circle-fill me-2"></i>
            Prompt link copied!
        `;

        Object.assign(
            toast.style,
            {
                position: 'fixed',
                bottom: '25px',
                right: '25px',
                zIndex: '9999',
                background: 'linear-gradient(135deg,#6366f1,#7c3aed)',
                color: '#ffffff',
                padding: '12px 18px',
                borderRadius: '12px',
                boxShadow: '0 12px 30px rgba(79,70,229,0.28)',
                fontWeight: '600',
                fontSize: '14px'
            }
        );

        document.body.appendChild(
            toast
        );

        setTimeout(function () {

            toast.remove();

        }, 2500);
    }


    /* =====================================================
       MODAL COPY
    ===================================================== */

    function copyModalPrompt() {

        const textarea =
            document.getElementById(
                'modalHiddenTextarea'
            );

        const btnElement =
            document.getElementById(
                'modalCopyBtn'
            );

        if (
            !textarea ||
            !btnElement
        ) {
            return;
        }

        copyTextToClipboard(
            textarea.value,
            btnElement
        );
    }


    /* =====================================================
       SEARCH SUGGESTIONS
    ===================================================== */

    $(document).ready(function () {

        $('#prompt-search').on(
            'keyup',
            function () {

                let query =
                    $(this).val();

                if (query.length > 1) {

                    $.ajax({

                        url:
                            "{{ route('search.suggestions') }}",

                        method:
                            "GET",

                        data: {
                            query: query
                        },

                        success:
                            function (data) {

                                let list =
                                    $('#suggestionList');

                                list.empty();

                                if (
                                    data.length > 0
                                ) {

                                    list.show();

                                    data.forEach(
                                        function (item) {

                                            let safeItem =
                                                encodeURIComponent(
                                                    JSON.stringify(item)
                                                );

                                            list.append(`
                                                <li
                                                    class="list-group-item list-group-item-action text-dark"
                                                    style="cursor:pointer;"
                                                    onclick="openSuggestionModal('${safeItem}')"
                                                >
                                                    <i class="bi bi-search me-2 text-primary"></i>
                                                    ${item.title}
                                                </li>
                                            `);
                                        }
                                    );

                                } else {

                                    list.hide();
                                }
                            },

                        error:
                            function (xhr) {

                                console.error(
                                    'Search suggestion error:',
                                    xhr
                                );

                                $('#suggestionList')
                                    .hide();
                            }
                    });

                } else {

                    $('#suggestionList')
                        .hide();
                }
            }
        );
    });


    /* =====================================================
       OPEN SEARCH SUGGESTION MODAL
    ===================================================== */

    function openSuggestionModal(
        encodedItem
    ) {

        let item =
            JSON.parse(
                decodeURIComponent(
                    encodedItem
                )
            );

        $('#modalPromptTitle')
            .text(item.title);

        $('#modalPromptText')
            .text(item.prompt_text);

        $('#modalHiddenTextarea')
            .val(item.prompt_text);

        $('#modalCategoryBadge')
            .text(
                item.category
                    ? item.category.name
                    : 'General'
            );

        if (item.image) {

            $('#modalPromptImage')
                .attr(
                    'src',
                    "{{ asset('storage') }}/" +
                    item.image
                );

            $('#modalImageContainer')
                .show();

        } else {

            $('#modalImageContainer')
                .hide();
        }

        $('#suggestionList')
            .hide();

        $('#prompt-search')
            .val('');

        let myModal =
            new bootstrap.Modal(
                document.getElementById(
                    'quickSuggestionModal'
                )
            );

        myModal.show();
    }


    /* =====================================================
       CLOSE SEARCH SUGGESTIONS
    ===================================================== */

    $(document).click(function (e) {

        if (
            !$(e.target).closest(
                '#prompt-search, #suggestionList'
            ).length
        ) {

            $('#suggestionList')
                .hide();
        }
    });


    /* =====================================================
       READ MORE / READ LESS
    ===================================================== */

    function toggleModalText(
        promptId
    ) {

        const shortTextEl =
            document.getElementById(
                `modal-text-short-${promptId}`
            );

        const fullTextEl =
            document.getElementById(
                `modal-text-full-${promptId}`
            );

        if (
            !shortTextEl ||
            !fullTextEl
        ) {
            return;
        }

        const btnEl =
            shortTextEl
                .closest('.modal-prompt-text')
                ?.querySelector('button');

        if (!btnEl) {
            return;
        }

        if (
            fullTextEl.style.display ===
            'none'
        ) {

            fullTextEl.style.display =
                'block';

            shortTextEl.style.display =
                'none';

            btnEl.innerHTML =
                'Read Less <i class="bi bi-chevron-up"></i>';

        } else {

            fullTextEl.style.display =
                'none';

            shortTextEl.style.display =
                'block';

            btnEl.innerHTML =
                'Read More <i class="bi bi-chevron-down"></i>';
        }
    }


    /* =====================================================
       SAVE PROMPT
    ===================================================== */

    function toggleSavePrompt(
        button
    ) {

        if (!button) {
            return;
        }

        if (
            button.dataset.saving ===
            '1'
        ) {
            return;
        }

        const promptId =
            button.dataset.promptId;

        const saveUrl =
            button.dataset.saveUrl;

        if (
            !promptId ||
            !saveUrl
        ) {

            console.error(
                'Save Prompt Error: prompt id or save URL missing.'
            );

            showSaveToast(
                'Unable to save this prompt.',
                false
            );

            return;
        }

        const currentlySaved =
            button.dataset.saved ===
            '1';

        const action =
            currentlySaved
                ? 'remove'
                : 'save';

        button.dataset.saving =
            '1';

        button.disabled =
            true;

        fetch(
            saveUrl,
            {
                method: 'POST',

                headers: {
                    'Content-Type':
                        'application/json',

                    'X-CSRF-TOKEN':
                        document
                            .querySelector(
                                'meta[name="csrf-token"]'
                            )
                            ?.getAttribute(
                                'content'
                            ),

                    'Accept':
                        'application/json'
                },

                body:
                    JSON.stringify({
                        action:
                            action
                    })
            }
        )
        .then(
            async function (response) {

                let data = {};

                try {

                    data =
                        await response.json();

                } catch (error) {

                    data = {};
                }

                if (!response.ok) {

                    throw new Error(
                        data.message ||
                        'Unable to update saved prompt.'
                    );
                }

                return data;
            }
        )
        .then(
            function (data) {

                const saved =
                    data.saved === true ||
                    data.saved === 1 ||
                    data.saved === '1';

                document
                    .querySelectorAll(
                        '.save-btn[data-prompt-id="' +
                        promptId +
                        '"]'
                    )
                    .forEach(
                        function (saveButton) {

                            const saveIcon =
                                saveButton.querySelector(
                                    'i'
                                );

                            const saveText =
                                saveButton.querySelector(
                                    'span'
                                );

                            saveButton.dataset.saved =
                                saved
                                    ? '1'
                                    : '0';

                            saveButton.classList.toggle(
                                'saved',
                                saved
                            );

                            saveButton.title =
                                saved
                                    ? 'Remove from Saved'
                                    : 'Save Prompt';

                            if (saveIcon) {

                                saveIcon.classList.remove(
                                    'bi-bookmark',
                                    'bi-bookmark-fill'
                                );

                                saveIcon.classList.add(
                                    saved
                                        ? 'bi-bookmark-fill'
                                        : 'bi-bookmark'
                                );
                            }

                            if (saveText) {

                                saveText.textContent =
                                    saved
                                        ? 'Saved'
                                        : 'Save';
                            }
                        }
                    );

                showSaveToast(
                    saved
                        ? 'Prompt saved successfully!'
                        : 'Removed from saved list.',
                    saved
                );
            }
        )
        .catch(
            function (error) {

                console.error(
                    'Save Prompt Error:',
                    error
                );

                showSaveToast(
                    error.message ||
                    'Something went wrong. Please try again.',
                    false
                );
            }
        )
        .finally(
            function () {

                button.dataset.saving =
                    '0';

                button.disabled =
                    false;
            }
        );
    }


    /* =====================================================
       SAVE TOAST
    ===================================================== */

    function showSaveToast(
        message,
        saved = true
    ) {

        const oldToast =
            document.getElementById(
                'saveSuccessToast'
            );

        if (oldToast) {
            oldToast.remove();
        }

        const toast =
            document.createElement(
                'div'
            );

        toast.id =
            'saveSuccessToast';

        toast.innerHTML = `
            <i class="bi ${
                saved
                    ? 'bi-bookmark-check-fill'
                    : 'bi-bookmark-x-fill'
            } me-2"></i>
            <span>${message}</span>
        `;

        Object.assign(
            toast.style,
            {
                position: 'fixed',
                bottom: '25px',
                right: '25px',
                zIndex: '99999',
                background:
                    saved
                        ? 'linear-gradient(135deg,#6366f1,#7c3aed)'
                        : 'linear-gradient(135deg,#64748b,#475569)',
                color: '#ffffff',
                padding: '13px 18px',
                borderRadius: '12px',
                boxShadow: '0 12px 30px rgba(79,70,229,0.28)',
                fontWeight: '600',
                fontSize: '14px',
                display: 'flex',
                alignItems: 'center',
                gap: '2px'
            }
        );

        document.body.appendChild(
            toast
        );

        setTimeout(function () {

            if (toast) {
                toast.remove();
            }

        }, 2500);
    }
</script>