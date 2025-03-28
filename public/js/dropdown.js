// Used to hide the dropdown when clicked outside of it
    $(document).ready(function () {
        $(document).on("click", function (e) {
            let $dropdown = $(".dt-button-collection");
            let $exportBtn = $(".buttons-collection");

            // Check if the click is outside the dropdown and export button
            if (!$exportBtn.is(e.target) && $exportBtn.has(e.target).length === 0) {
                $dropdown.hide();
            }
        });
    });
