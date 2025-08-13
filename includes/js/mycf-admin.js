jQuery(document).ready(function ($) {
    function loadEntries(page = 1) {
        $.post(mycf_ajax_obj.ajax_url, {
            action: 'mycf_get_entries',
            nonce: mycf_ajax_obj.nonce,
            paged: page
        }, function (response) {
            if (response.entries) {
                let rows = '';
                let startNum = (page - 1) * 5 + 1; // Serial number start based on pagination

                $.each(response.entries, function (i, entry) {
                    rows += `<tr>
                        <td>${startNum + i}</td>
                        <td>${entry.name}</td>
                        <td>${entry.email}</td>
                        <td>${entry.phone}</td>
                        <td>${entry.message.length > 50 ? entry.message.substring(0, 50) + '...' : entry.message}</td>
                        <td>${entry.created_at}</td>
                        <td>
                            <button class="mycf-view" data-id="${entry.id}">View</button>
                            <button class="mycf-delete" data-id="${entry.id}">Delete</button>
                        </td>
                    </tr>`;
                });
                $('#mycf-entries-body').html(rows);

                let pagination = '';
                for (let i = 1; i <= response.pages; i++) {
                    pagination += `<button class="mycf-page-btn" data-page="${i}" ${i === response.current ? 'disabled' : ''}>${i}</button>`;
                }
                $('#mycf-pagination').html(pagination);
            }
        }, 'json');
    }

    loadEntries();

    $(document).on('click', '.mycf-page-btn', function () {
        loadEntries($(this).data('page'));
    });

    $(document).on('click', '.mycf-delete', function () {
        if (confirm('Are you sure you want to delete this entry?')) {
            $.post(mycf_ajax_obj.ajax_url, {
                action: 'mycf_delete_entry',
                nonce: mycf_ajax_obj.nonce,
                id: $(this).data('id')
            }, function (res) {
                if (res.success) {
                    loadEntries();
                } else {
                    alert(res.data);
                }
            }, 'json');
        }
    });

    // Optional: View button for full message (future modal)
    $(document).on('click', '.mycf-view', function () {
        alert('Viewing entry ID: ' + $(this).data('id') + '\n(Modal view can be added here)');
    });
});
