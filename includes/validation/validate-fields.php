<?php
function validate_required_fields($fields, &$errors, &$sanitized) {
    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . " yra būtinas!";
        } else {
            $sanitized[$field] = sanitize_text_field($_POST[$field]);
        }
    }
}
