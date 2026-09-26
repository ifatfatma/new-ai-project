 <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    ></script>


    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
    ></script>


    <script>


        /* =====================================================
           CUSTOM AI TOOLS DROPDOWN
        ===================================================== */

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const dropdown =
                    document.getElementById(
                        'aiToolsDropdown'
                    );

                const dropdownBtn =
                    document.getElementById(
                        'aiToolsDropdownBtn'
                    );

                const dropdownMenu =
                    document.getElementById(
                        'aiToolsDropdownMenu'
                    );

                const selectedToolsText =
                    document.getElementById(
                        'selectedToolsText'
                    );


                if (
                    !dropdown ||
                    !dropdownBtn ||
                    !dropdownMenu ||
                    !selectedToolsText
                ) {
                    return;
                }


                function updateSelectedTools()
                {

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


                    checkedTools.forEach(
                        function (checkbox) {

                            const option =
                                checkbox.closest(
                                    '.ai-tool-option'
                                );

                            const name =
                                option
                                    ? option.querySelector(
                                        '.ai-tool-name'
                                    )
                                    : null;


                            if (name) {

                                selectedNames.push(
                                    name.textContent.trim()
                                );

                            }

                        }
                    );


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

                        dropdown.classList.toggle(
                            'open'
                        );

                    }
                );


                const checkboxes =
                    dropdownMenu.querySelectorAll(
                        'input[type="checkbox"]'
                    );


                checkboxes.forEach(
                    function (checkbox) {

                        checkbox.addEventListener(
                            'change',
                            function () {

                                updateSelectedTools();

                            }
                        );

                    }
                );


                document.addEventListener(
                    'click',
                    function (event) {

                        if (
                            !dropdown.contains(
                                event.target
                            )
                        ) {

                            dropdown.classList.remove(
                                'open'
                            );

                        }

                    }
                );


                updateSelectedTools();

            }
        );


        /* =====================================================
           COPY PROMPT
           VARIABLES ARE OPTIONAL
        ===================================================== */

        function copyPrompt(
            elementId,
            btnElement,
            promptId
        )
        {

            const element =
                document.getElementById(elementId);


            if (!element) {
                return;
            }


            const originalText =
                element.value;


            let scope =
                btnElement.closest('.modal');


            if (!scope) {

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


            /*
             * Agar prompt mein variables hi nahi hain,
             * to normal prompt copy hoga.
             */

            if (variableFields.length === 0) {

                copyTextToClipboard(
                    originalText,
                    btnElement,
                    promptId
                );

                return;

            }


            const values = {};

            let hasAnyValue = false;


            /*
             * Sabhi variable values collect karo.
             * Empty fields allowed hain.
             */

            variableFields.forEach(
                function (field) {

                    const variableNumber =
                        field.dataset.variable;

                    const value =
                        field.value.trim();


                    values[variableNumber] =
                        value;


                    if (value !== '') {

                        hasAnyValue = true;

                    }

                }
            );


            /*
             * IMPORTANT:
             *
             * Agar user ne ek bhi field fill nahi kiya,
             * to ORIGINAL prompt exactly copy hoga.
             *
             * Example:
             *
             * "Create [1] image with [2] background."
             *
             * Result:
             *
             * "Create [1] image with [2] background."
             */

            if (!hasAnyValue) {

                copyTextToClipboard(
                    originalText,
                    btnElement,
                    promptId
                );

                return;

            }


            /*
             * Kam se kam ek field filled hai.
             *
             * Filled variables replace honge.
             * Empty variables remove honge.
             */

            let textToCopy =
                originalText.replace(
                    /\[(\d+)\]/g,
                    function (
                        match,
                        variableNumber
                    ) {

                        return values[variableNumber] || '';

                    }
                );


            /*
             * Empty variables ke baad unwanted
             * punctuation / connector words clean karo.
             */

            textToCopy =
                cleanPromptText(textToCopy);


            copyTextToClipboard(
                textToCopy,
                btnElement,
                promptId
            );

        }


        /* =====================================================
           CLEAN PROMPT TEXT
           REMOVE EMPTY VARIABLE LEFTOVERS
        ===================================================== */

        function cleanPromptText(text)
        {

            /*
             * New lines ke unnecessary spaces.
             */

            text =
                text.replace(
                    /[ \t]+/g,
                    ' '
                );


            /*
             * Comma ke baad empty connector.
             *
             * Example:
             *
             * "portrait, wearing , in studio"
             *
             * becomes:
             *
             * "portrait, in studio"
             */

            text =
                text.replace(
                    /,\s*(with|wearing|in|on|at|for|from|using|featuring|including|showing|holding|against|beside|near)\s*(?=[,.;!?]|$)/gi,
                    ''
                );


            /*
             * Agar connector ke baad comma aa gaya.
             *
             * Example:
             *
             * "portrait with ,"
             *
             * becomes:
             *
             * "portrait"
             */

            text =
                text.replace(
                    /\s+(with|wearing|in|on|at|for|from|using|featuring|including|showing|holding|against|beside|near)\s*(?=[,.;!?]|$)/gi,
                    ''
                );


            /*
             * Empty "and".
             */

            text =
                text.replace(
                    /,\s*and\s*(?=[,.;!?]|$)/gi,
                    ''
                );


            /*
             * Empty "with" / "in" etc before punctuation.
             */

            text =
                text.replace(
                    /\b(with|wearing|in|on|at|from|using|featuring|including|showing|holding|against|beside|near)\s*,/gi,
                    ','
                );


            /*
             * Double commas.
             */

            text =
                text.replace(
                    /,\s*,+/g,
                    ','
                );


            /*
             * Comma directly before punctuation.
             */

            text =
                text.replace(
                    /,\s*\./g,
                    '.'
                );


            text =
                text.replace(
                    /,\s*!/g,
                    '!'
                );


            text =
                text.replace(
                    /,\s*\?/g,
                    '?'
                );


            text =
                text.replace(
                    /,\s*;/g,
                    ';'
                );


            text =
                text.replace(
                    /,\s*:/g,
                    ':'
                );


            /*
             * Punctuation se pehle unwanted spaces.
             */

            text =
                text.replace(
                    /\s+([,.!?;:])/g,
                    '$1'
                );


            /*
             * Duplicate punctuation.
             */

            text =
                text.replace(
                    /([,.!?])\1+/g,
                    '$1'
                );


            /*
             * Multiple spaces.
             */

            text =
                text.replace(
                    /[ \t]{2,}/g,
                    ' '
                );


            /*
             * Multiple blank lines ko clean karo,
             * lekin normal paragraph structure preserve rahe.
             */

            text =
                text.replace(
                    /\n[ \t]+/g,
                    '\n'
                );


            text =
                text.replace(
                    /\n{3,}/g,
                    '\n\n'
                );


            return text.trim();

        }


        /* =====================================================
           CLIPBOARD HELPER
        ===================================================== */

        function copyTextToClipboard(
            textToCopy,
            btnElement,
            promptId
        )
        {

            navigator.clipboard
                .writeText(textToCopy)
                .then(
                    function () {

                        const originalContent =
                            btnElement.innerHTML;


                        btnElement.innerHTML =
                            '<i class="bi bi-check2 me-1"></i> Copied!';


                        btnElement.classList.remove(
                            'copy-btn'
                        );


                        btnElement.classList.add(
                            'btn-dark'
                        );


                        setTimeout(
                            function () {

                                btnElement.innerHTML =
                                    originalContent;


                                btnElement.classList.remove(
                                    'btn-dark'
                                );


                                btnElement.classList.add(
                                    'copy-btn'
                                );

                            },
                            2000
                        );


                        /*
                         * Copy tracking same as before.
                         */

                        fetch(
                            `/prompts/${promptId}/copy-track`,
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
                                            .getAttribute(
                                                'content'
                                            )

                                }
                            }
                        )
                        .catch(
                            function (err) {

                                console.error(
                                    'Tracking Error:',
                                    err
                                );

                            }
                        );

                    }
                )
                .catch(
                    function (err) {

                        console.error(
                            'Failed to copy:',
                            err
                        );


                        showVariableToast(
                            'Unable to copy the prompt.'
                        );

                    }
                );

        }


        /* =====================================================
           RESET VARIABLES
        ===================================================== */

        function resetPromptVariables(promptId)
        {

            document
                .querySelectorAll(
                    `.prompt-variable-input[data-prompt-id="${promptId}"]`
                )
                .forEach(
                    function (field) {

                        field.value = '';

                    }
                );

        }


        /* =====================================================
           VARIABLE TOAST
        ===================================================== */

        function showVariableToast(message)
        {

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


            toast.style.position =
                'fixed';

            toast.style.bottom =
                '25px';

            toast.style.left =
                '50%';

            toast.style.transform =
                'translateX(-50%)';

            toast.style.zIndex =
                '99999';

            toast.style.background =
                '#111827';

            toast.style.color =
                '#ffffff';

            toast.style.padding =
                '12px 18px';

            toast.style.borderRadius =
                '10px';

            toast.style.boxShadow =
                '0 10px 30px rgba(0,0,0,0.20)';

            toast.style.fontWeight =
                '600';

            toast.style.fontSize =
                '13px';

            toast.style.display =
                'flex';

            toast.style.alignItems =
                'center';


            document.body.appendChild(
                toast
            );


            setTimeout(
                function () {

                    if (toast) {
                        toast.remove();
                    }

                },
                2500
            );

        }


        /* =====================================================
           SHARE PROMPT
        ===================================================== */

        function sharePrompt(
            promptId,
            promptTitle
        )
        {

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
                .catch(
                    function (error) {

                        if (
                            error.name !==
                            'AbortError'
                        ) {

                            console.error(
                                'Share failed:',
                                error
                            );

                        }

                    }
                );

                return;
            }


            navigator.clipboard
                .writeText(shareUrl)
                .then(
                    function () {

                        showShareToast();

                    }
                )
                .catch(
                    function () {

                        window.prompt(
                            'Copy this prompt link:',
                            shareUrl
                        );

                    }
                );

        }


        /* =====================================================
           SHARE TOAST
        ===================================================== */

        function showShareToast()
        {

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


            toast.style.position =
                'fixed';

            toast.style.bottom =
                '25px';

            toast.style.right =
                '25px';

            toast.style.zIndex =
                '9999';

            toast.style.background =
                'linear-gradient(135deg,#6366f1,#7c3aed)';

            toast.style.color =
                '#ffffff';

            toast.style.padding =
                '12px 18px';

            toast.style.borderRadius =
                '12px';

            toast.style.boxShadow =
                '0 12px 30px rgba(79,70,229,0.28)';

            toast.style.fontWeight =
                '600';

            toast.style.fontSize =
                '14px';


            document.body.appendChild(
                toast
            );


            setTimeout(
                function () {

                    toast.remove();

                },
                2500
            );

        }


        /* =====================================================
           MODAL COPY
        ===================================================== */

        function copyModalPrompt()
        {

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


            const textToCopy =
                textarea.value;


            navigator.clipboard
                .writeText(textToCopy)
                .then(
                    function () {

                        const originalContent =
                            btnElement.innerHTML;


                        btnElement.innerHTML =
                            '<i class="bi bi-check2 me-1"></i> Copied!';


                        btnElement.classList.remove(
                            'copy-btn'
                        );


                        btnElement.classList.add(
                            'btn-dark'
                        );


                        setTimeout(
                            function () {

                                btnElement.innerHTML =
                                    originalContent;


                                btnElement.classList.remove(
                                    'btn-dark'
                                );


                                btnElement.classList.add(
                                    'copy-btn'
                                );

                            },
                            2000
                        );

                    }
                )
                .catch(
                    function (err) {

                        console.error(
                            'Failed to copy:',
                            err
                        );

                    }
                );

        }


        /* =====================================================
           SEARCH SUGGESTIONS
        ===================================================== */

        $(document).ready(
            function () {

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

                                    query:
                                        query

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
                                                            JSON.stringify(
                                                                item
                                                            )
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

                                    }

                            });

                        } else {

                            $('#suggestionList')
                                .hide();

                        }

                    }
                );

            }
        );


        /* =====================================================
           OPEN SEARCH SUGGESTION MODAL
        ===================================================== */

        function openSuggestionModal(
            encodedItem
        )
        {

            let item =
                JSON.parse(
                    decodeURIComponent(
                        encodedItem
                    )
                );


            $('#modalPromptTitle')
                .text(
                    item.title
                );


            $('#modalPromptText')
                .text(
                    item.prompt_text
                );


            $('#modalHiddenTextarea')
                .val(
                    item.prompt_text
                );


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
                        "{{ asset('storage') }}/"
                        + item.image
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

        $(document).click(
            function (e) {

                if (
                    !$(e.target).closest(
                        '#prompt-search, #suggestionList'
                    ).length
                ) {

                    $('#suggestionList')
                        .hide();

                }

            }
        );


        /* =====================================================
           READ MORE / READ LESS
        ===================================================== */

        function toggleModalText(
            promptId
        )
        {

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
                    .querySelector(
                        'button'
                    );


            if (
                fullTextEl.style.display === 'none'
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

        function toggleSavePrompt(button)
        {

            if (!button) {
                return;
            }


            if (button.dataset.saving === '1') {
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
                button.dataset.saved === '1';


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
                                .getAttribute(
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
        )
        {

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


            toast.style.position =
                'fixed';

            toast.style.bottom =
                '25px';

            toast.style.right =
                '25px';

            toast.style.zIndex =
                '99999';

            toast.style.background =
                saved
                    ? 'linear-gradient(135deg,#6366f1,#7c3aed)'
                    : 'linear-gradient(135deg,#64748b,#475569)';

            toast.style.color =
                '#ffffff';

            toast.style.padding =
                '13px 18px';

            toast.style.borderRadius =
                '12px';

            toast.style.boxShadow =
                '0 12px 30px rgba(79,70,229,0.28)';

            toast.style.fontWeight =
                '600';

            toast.style.fontSize =
                '14px';

            toast.style.display =
                'flex';

            toast.style.alignItems =
                'center';

            toast.style.gap =
                '2px';


            document.body.appendChild(
                toast
            );


            setTimeout(
                function () {

                    if (toast) {
                        toast.remove();
                    }

                },
                2500
            );

        }

    </script>
