<style>
    #mycf-entries-table table {
        border-collapse: collapse;
        width: 100%;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    #mycf-entries-table th, 
    #mycf-entries-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #e1e1e1;
    }
    #mycf-entries-table th {
        background: #f8f9fa;
        font-weight: 600;
    }
    #mycf-pagination {
        margin-top: 15px;
        text-align: center;
    }
    #mycf-pagination button {
        background: #f0f0f0;
        border: 1px solid #ccc;
        margin: 0 3px;
        padding: 5px 10px;
        cursor: pointer;
    }
    #mycf-pagination button:disabled {
        background: #0073aa;
        color: #fff;
        border-color: #0073aa;
        cursor: default;
    }
    .mycf-delete {
        background: #d63638;
        color: #fff;
        border: none;
        padding: 4px 8px;
        cursor: pointer;
        border-radius: 3px;
    }
    .mycf-delete:hover {
        background: #a30000;
    }
    .mycf-view {
        background: #2271b1;
        color: #fff;
        border: none;
        padding: 4px 8px;
        cursor: pointer;
        border-radius: 3px;
        margin-right: 5px;
    }
    .mycf-view:hover {
        background: #005177;
    }
</style>

<table class="widefat fixed striped">
    <thead>
        <tr>
            <th><?php esc_html_e( '#', 'my-custom-form' ); ?></th>
            <th><?php esc_html_e( 'Name', 'my-custom-form' ); ?></th>
            <th><?php esc_html_e( 'Email', 'my-custom-form' ); ?></th>
            <th><?php esc_html_e( 'Phone', 'my-custom-form' ); ?></th>
            <th><?php esc_html_e( 'Message', 'my-custom-form' ); ?></th>
            <th><?php esc_html_e( 'Date', 'my-custom-form' ); ?></th>
            <th><?php esc_html_e( 'Actions', 'my-custom-form' ); ?></th>
        </tr>
    </thead>
    <tbody id="mycf-entries-body">
        <tr>
            <td colspan="7"><?php esc_html_e( 'Loading entries...', 'my-custom-form' ); ?></td>
        </tr>
    </tbody>
</table>

<div id="mycf-pagination"></div>
