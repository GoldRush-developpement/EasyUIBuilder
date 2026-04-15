<?php

namespace refaltor\ui\validators;

class JsonValidator
{
    const VALID_TYPES = [
        'panel', 'stack_panel', 'label', 'image', 'button', 'toggle',
        'slider', 'edit_box', 'dropdown', 'grid', 'scroll_view',
        'input_panel', 'screen', 'custom',
    ];

    const VALID_ANCHORS = [
        'top_left', 'top_middle', 'top_right',
        'left_middle', 'center', 'right_middle',
        'bottom_left', 'bottom_middle', 'bottom_right',
    ];

    const VALID_FONT_SIZES = [
        'small', 'normal', 'large', 'extra_large',
    ];

    const VALID_FONT_TYPES = [
        'default', 'rune', 'unicode', 'smooth', 'MinecraftTen',
    ];

    const VALID_TEXT_TYPES = [
        'ExtendedASCII', 'IdentifierChars', 'NumberChars',
    ];

    const VALID_ORIENTATIONS = [
        'vertical', 'horizontal',
    ];

    const VALID_CLIP_DIRECTIONS = [
        'left', 'right', 'up', 'down', 'center',
    ];

    const VALID_GRID_RESCALING_TYPES = [
        'none', 'horizontal', 'vertical',
    ];

    const VALID_GRID_FILL_DIRECTIONS = [
        'none', 'horizontal', 'vertical',
        'left_to_right', 'right_to_left', 'top_to_bottom', 'bottom_to_top',
    ];

    const VALID_TEXTURE_FILE_SYSTEMS = [
        'InUserPackage', 'InAppPackage', 'RawPath', 'RawPersistent',
        'InSettingsDir', 'InExternalDir', 'InServerPackage',
        'InDataPackage', 'InUserCachePackage', 'InWorldPackage',
    ];

    const VALID_BINDING_TYPES = [
        'global', 'view', 'collection', 'collection_details', 'none',
    ];

    const VALID_BINDING_CONDITIONS = [
        'always', 'once', 'visible', 'always_when_visible',
        'visibility_changed', 'none',
    ];

    const VALID_ANIM_TYPES = [
        'alpha', 'offset', 'size', 'flip_book', 'uv',
        'color', 'wait', 'aseprite_flip_book', 'clip',
    ];

    const VALID_EASINGS = [
        'linear', 'spring',
        'in_quad', 'out_quad', 'in_out_quad',
        'in_cubic', 'out_cubic', 'in_out_cubic',
        'in_quart', 'out_quart', 'in_out_quart',
        'in_quint', 'out_quint', 'in_out_quint',
        'in_sine', 'out_sine', 'in_out_sine',
        'in_expo', 'out_expo', 'in_out_expo',
        'in_circ', 'out_circ', 'in_out_circ',
        'in_bounce', 'out_bounce', 'in_out_bounce',
        'in_back', 'out_back', 'in_out_back',
        'in_elastic', 'out_elastic', 'in_out_elastic',
    ];

    const VALID_RENDERERS = [
        'paper_doll_renderer', 'live_horse_renderer', 'live_player_renderer',
        'inventory_item_renderer', 'hotbar_item_renderer', 'hud_player_renderer',
        'enchanting_book_renderer', '3d_structure_renderer', 'progress_bar_renderer',
        'actor_portrait_renderer', 'banner_renderer', 'trial_renderer',
        'panorama_renderer', 'gradient_renderer', 'name_tag_renderer',
        'flying_item_renderer', 'hover_text_renderer', 'credits_renderer',
        'vignette_renderer', 'splash_text_renderer',
    ];

    const VALID_BUTTON_MAPPINGS_TYPES = [
        'pressed', 'clicked', 'focused', 'double_pressed', 'global',
    ];

    const VALID_INPUT_MODE_CONDITIONS = [
        'not_gaze', 'gamepad_and_not_gaze', 'any',
    ];

    /** Common properties shared by all element types */
    const COMMON_PROPERTIES = [
        'type', 'size', 'offset', 'anchor_from', 'anchor_to', 'layer',
        'alpha', 'visible', 'enabled', 'ignored', 'clips_children',
        'allow_clipping', 'clip_offset', 'min_size', 'max_size',
        'property_bag', 'controls', 'bindings', 'variables', 'anims',
        'propagate_alpha', 'inherit_max_sibling_width',
        'inherit_max_sibling_height', 'use_anchored_offset',
        'contained', 'draggable', 'follows_cursor',
        'debug', 'grid_position', 'collection_index',
        'modifications', 'factory',
    ];

    /** Type-specific properties per element type */
    const TYPE_PROPERTIES = [
        'label' => [
            'text', 'color', 'shadow', 'font_size', 'font_scale_factor',
            'font_type', 'localize', 'line_padding', 'enable_profanity_filter',
            'hide_hyphen', 'notify_on_ellipses',
        ],
        'image' => [
            'texture', 'uv', 'uv_size', 'texture_file_system', 'nineslice_size',
            'tiled', 'tiled_scale', 'clip_direction', 'clip_ratio',
            'clip_pixelperfect', 'keep_ratio', 'bilinear', 'fill',
            'fit_to_width', 'zip_folder', 'grayscale', 'force_texture_reload',
            'base_size', 'color', 'allow_debug_missing_texture',
        ],
        'panel' => [
            'clip_state_change_event', 'enable_scissor_test', 'selected',
            'use_child_anchors', 'disable_anim_fast_forward',
            'animation_reset_name',
        ],
        'stack_panel' => [
            'orientation', 'clip_state_change_event', 'enable_scissor_test',
            'selected', 'use_child_anchors', 'disable_anim_fast_forward',
            'animation_reset_name',
        ],
        'button' => [
            'default_control', 'hover_control', 'pressed_control', 'locked_control',
            'pressed_button_name', 'sound_name', 'sound_volume', 'sound_pitch',
            '$pressed_button_name', '$button_text', '$button_text_binding_type',
            '$button_state_panel|default', '$button_text_grid_collection_name',
            '$default_button_texture', '$hover_button_texture',
            '$pressed_button_texture', '$locked_button_texture',
            '$focus_enabled', '$focus_wrap_enabled', '$condition', '$size',
            '$border_visible', 'button_text', 'button_text_binding_type',
            'button_text_grid_collection_name', 'button_text_max_size',
        ],
        'toggle' => [
            'toggle_name', 'toggle_default_state', 'toggle_group_default_tab',
            'toggle_group_forced_index', 'reset_on_focus_lost', 'toggle_on_button',
            'toggle_off_button', 'enable_directional_toggling', 'radio_toggle_group',
            'toggle_tab_index', 'checked_control', 'unchecked_control',
            'checked_hover_control', 'unchecked_hover_control',
            'checked_locked_control', 'unchecked_locked_control',
            'checked_locked_hover_control', 'unchecked_locked_hover_control',
            'sound_name', 'sound_volume', 'sound_pitch',
        ],
        'slider' => [
            'slider_track_button', 'slider_small_decrease_button',
            'slider_small_increase_button', 'slider_steps', 'slider_direction',
            'slider_timeout', 'slider_collection_name', 'slider_name',
            'slider_select_on_hover', 'default_control',
            'background_control', 'background_hover_control',
            'progress_control', 'progress_hover_control',
            'slider_box_control', 'slider_box_hover_control',
            'slider_box_locked_control', 'slider_box_indeterminate_control',
        ],
        'edit_box' => [
            'text_box_name', 'place_holder_text', 'place_holder_text_color',
            'max_length', 'text_box_visible', 'enabled_newline', 'text_type',
            'text_edit_box_grid_collection_name', 'constrained_text_edit_box',
            'virtual', 'text_color', 'locked_color',
        ],
        'dropdown' => [
            'dropdown_name', 'dropdown_content_control', 'dropdown_area',
            'dropdown_scroll_content_panel',
        ],
        'grid' => [
            'grid_dimensions', 'maximum_grid_items', 'grid_dimension_binding',
            'grid_rescaling_type', 'grid_fill_direction', 'grid_item_template',
            'precached_grid_item_count', 'collection_name',
        ],
        'scroll_view' => [
            'scrollbar_touch_button', 'scroll_content', 'scroll_bar_track',
            'scroll_bar_box', 'scroll_bar_box_track', 'scroll_speed',
            'scroll_bar_box_middle_size', 'always_listen_to_input',
            'jump_to_bottom_on_update', 'touch_mode', 'scrollbar_track_button',
            'scroll_size', 'orientation',
        ],
        'input_panel' => [
            'modal', 'inline_modal', 'always_listen_to_input', 'focus_enabled',
            'focus_wrap_enabled', 'focus_magnet_enabled', 'focus_magnet_distance',
            'focus_identifier', 'focus_change_up', 'focus_change_down',
            'focus_change_left', 'focus_change_right',
            'focus_navigation_mode_left', 'focus_navigation_mode_right',
            'focus_navigation_mode_up', 'focus_navigation_mode_down',
            'focus_container_custom', 'use_last_focus',
            'gesture_tracking_button', 'always_handle_pointer',
            'button_mappings', 'default_focus_precedence',
        ],
        'screen' => [
            'render_only_when_topmost', 'render_game_behind', 'absorbs_input',
            'is_showing_menu', 'is_modal', 'should_steal_mouse',
            'low_frequency_rendering', 'screen_not_flushable',
            'always_accepts_input', 'force_render_below', 'send_telemetry',
            'close_on_player_hurt', 'cache_screen', 'screen_draws_last',
        ],
        'custom' => [
            'renderer', 'property_bag', 'primary_color',
            'enable_profanity_filter', 'locked', 'color',
        ],
    ];

    private bool $strictMode;

    public function __construct(bool $strictMode = false)
    {
        $this->strictMode = $strictMode;
    }

    /**
     * Validates a complete JSON UI file (namespace + elements + animations).
     */
    public function validate(array $jsonData): ValidationResult
    {
        $result = new ValidationResult();

        if (!isset($jsonData['namespace'])) {
            $result->addError("The 'namespace' field is required at the root of the JSON UI file.");
        } elseif (!is_string($jsonData['namespace']) || $jsonData['namespace'] === '') {
            $result->addError("The 'namespace' field must be a non-empty string.");
        }

        foreach ($jsonData as $key => $value) {
            if ($key === 'namespace') continue;
            if (!is_array($value)) continue;

            $elementName = $this->extractElementName($key);
            $elementResult = new ValidationResult($elementName);

            if (isset($value['anim_type'])) {
                $this->validateAnimation($value, $elementResult);
            } elseif (isset($value['type'])) {
                $this->validateElement($key, $value, $elementResult);
            }

            $result->merge($elementResult);
        }

        return $result;
    }

    /**
     * Validates the _ui_defs.json structure.
     */
    public function validateUiDefs(array $jsonData): ValidationResult
    {
        $result = new ValidationResult('_ui_defs.json');

        if (!isset($jsonData['ui_defs'])) {
            $result->addError("The 'ui_defs' field is required.");
            return $result;
        }

        if (!is_array($jsonData['ui_defs'])) {
            $result->addError("The 'ui_defs' field must be an array.");
            return $result;
        }

        foreach ($jsonData['ui_defs'] as $index => $path) {
            if (!is_string($path)) {
                $result->addError("Entry #{$index} must be a string (path to a JSON file).");
                continue;
            }
            if (!str_ends_with($path, '.json')) {
                $result->addWarning("Entry '{$path}' does not end with '.json'.");
            }
        }

        $unique = array_unique($jsonData['ui_defs']);
        if (count($unique) !== count($jsonData['ui_defs'])) {
            $result->addWarning("Duplicate entries found in the 'ui_defs' list.");
        }

        return $result;
    }

    /**
     * Validates an individual UI element.
     */
    private function validateElement(string $key, array $data, ValidationResult $result): void
    {
        $type = $data['type'];

        if (!in_array($type, self::VALID_TYPES)) {
            $result->addError("Unknown element type: '{$type}'. Valid types: " . implode(', ', self::VALID_TYPES));
            return;
        }

        $this->validateElementProperties($type, $data, $result);

        if (isset($data['anchor_from'])) {
            $this->validateEnum($data['anchor_from'], self::VALID_ANCHORS, 'anchor_from', $result);
        }
        if (isset($data['anchor_to'])) {
            $this->validateEnum($data['anchor_to'], self::VALID_ANCHORS, 'anchor_to', $result);
        }

        if (isset($data['size'])) {
            $this->validateSize($data['size'], $result);
        }
        if (isset($data['offset'])) {
            $this->validateOffset($data['offset'], $result);
        }
        if (isset($data['alpha'])) {
            $this->validateRange($data['alpha'], 0.0, 1.0, 'alpha', $result);
        }
        if (isset($data['layer']) && !is_int($data['layer'])) {
            $result->addError("Property 'layer' must be an integer.");
        }

        if (isset($data['bindings'])) {
            $this->validateBindings($data['bindings'], $result);
        }
        if (isset($data['variables'])) {
            $this->validateVariables($data['variables'], $result);
        }
        if (isset($data['controls'])) {
            $this->validateControls($data['controls'], $result);
        }

        // Type-specific validations
        switch ($type) {
            case 'label':
                $this->validateLabel($data, $result);
                break;
            case 'image':
                $this->validateImage($data, $result);
                break;
            case 'grid':
                $this->validateGrid($data, $result);
                break;
            case 'scroll_view':
            case 'stack_panel':
                if (isset($data['orientation'])) {
                    $this->validateEnum($data['orientation'], self::VALID_ORIENTATIONS, 'orientation', $result);
                }
                break;
            case 'edit_box':
                $this->validateEditBox($data, $result);
                break;
            case 'slider':
                $this->validateSlider($data, $result);
                break;
            case 'input_panel':
                $this->validateInputPanel($data, $result);
                break;
            case 'custom':
                $this->validateCustomRenderer($data, $result);
                break;
        }
    }

    /**
     * Checks that element properties are known for its type.
     */
    private function validateElementProperties(string $type, array $data, ValidationResult $result): void
    {
        if (!$this->strictMode) return;

        $allowedProperties = array_merge(
            self::COMMON_PROPERTIES,
            self::TYPE_PROPERTIES[$type] ?? []
        );

        foreach (array_keys($data) as $property) {
            // Properties starting with $ are template variables
            if (str_starts_with($property, '$')) continue;
            if (!in_array($property, $allowedProperties)) {
                $result->addWarning("Unknown property '{$property}' for type '{$type}'.");
            }
        }
    }

    private function validateLabel(array $data, ValidationResult $result): void
    {
        if (isset($data['font_size'])) {
            $this->validateEnum($data['font_size'], self::VALID_FONT_SIZES, 'font_size', $result);
        }
        if (isset($data['font_type'])) {
            $this->validateEnum($data['font_type'], self::VALID_FONT_TYPES, 'font_type', $result);
        }
        if (isset($data['font_scale_factor'])) {
            if (!is_numeric($data['font_scale_factor']) || $data['font_scale_factor'] <= 0) {
                $result->addError("Property 'font_scale_factor' must be a positive number.");
            }
        }
        if (isset($data['color'])) {
            $this->validateColor($data['color'], $result);
        }
    }

    private function validateImage(array $data, ValidationResult $result): void
    {
        if (!isset($data['texture']) || $data['texture'] === '') {
            $result->addWarning("Image has no 'texture' defined.");
        }
        if (isset($data['texture_file_system'])) {
            $this->validateEnum($data['texture_file_system'], self::VALID_TEXTURE_FILE_SYSTEMS, 'texture_file_system', $result);
        }
        if (isset($data['clip_direction'])) {
            $this->validateEnum($data['clip_direction'], self::VALID_CLIP_DIRECTIONS, 'clip_direction', $result);
        }
        if (isset($data['clip_ratio'])) {
            $this->validateRange($data['clip_ratio'], 0.0, 1.0, 'clip_ratio', $result);
        }
        if (isset($data['uv']) && is_array($data['uv'])) {
            if (count($data['uv']) !== 2) {
                $result->addError("Property 'uv' must contain exactly 2 values [x, y].");
            }
        }
        if (isset($data['uv_size']) && is_array($data['uv_size'])) {
            if (count($data['uv_size']) !== 2) {
                $result->addError("Property 'uv_size' must contain exactly 2 values [width, height].");
            }
        }
    }

    private function validateGrid(array $data, ValidationResult $result): void
    {
        if (isset($data['grid_dimensions']) && is_array($data['grid_dimensions'])) {
            if (count($data['grid_dimensions']) !== 2) {
                $result->addError("Property 'grid_dimensions' must contain exactly 2 values [columns, rows].");
            }
        }
        if (isset($data['grid_rescaling_type'])) {
            $this->validateEnum($data['grid_rescaling_type'], self::VALID_GRID_RESCALING_TYPES, 'grid_rescaling_type', $result);
        }
        if (isset($data['grid_fill_direction'])) {
            $this->validateEnum($data['grid_fill_direction'], self::VALID_GRID_FILL_DIRECTIONS, 'grid_fill_direction', $result);
        }
        if (isset($data['maximum_grid_items']) && (!is_int($data['maximum_grid_items']) || $data['maximum_grid_items'] < 0)) {
            $result->addError("Property 'maximum_grid_items' must be a non-negative integer.");
        }
    }

    private function validateEditBox(array $data, ValidationResult $result): void
    {
        if (isset($data['text_type'])) {
            $this->validateEnum($data['text_type'], self::VALID_TEXT_TYPES, 'text_type', $result);
        }
        if (isset($data['max_length'])) {
            if (!is_int($data['max_length']) || $data['max_length'] <= 0) {
                $result->addError("Property 'max_length' must be a positive integer.");
            }
        }
    }

    private function validateSlider(array $data, ValidationResult $result): void
    {
        if (isset($data['slider_direction'])) {
            $this->validateEnum($data['slider_direction'], self::VALID_ORIENTATIONS, 'slider_direction', $result);
        }
        if (isset($data['slider_steps'])) {
            if (!is_numeric($data['slider_steps']) || $data['slider_steps'] <= 0) {
                $result->addError("Property 'slider_steps' must be a positive number.");
            }
        }
    }

    private function validateInputPanel(array $data, ValidationResult $result): void
    {
        if (isset($data['button_mappings']) && is_array($data['button_mappings'])) {
            foreach ($data['button_mappings'] as $index => $mapping) {
                if (!is_array($mapping)) {
                    $result->addError("button_mapping #{$index} must be an array.");
                    continue;
                }
                if (!isset($mapping['from_button_id'])) {
                    $result->addError("button_mapping #{$index} requires 'from_button_id'.");
                }
                if (!isset($mapping['to_button_id'])) {
                    $result->addError("button_mapping #{$index} requires 'to_button_id'.");
                }
                if (isset($mapping['mapping_type'])) {
                    $this->validateEnum($mapping['mapping_type'], self::VALID_BUTTON_MAPPINGS_TYPES, "button_mapping #{$index} mapping_type", $result);
                }
                if (isset($mapping['input_mode_condition'])) {
                    $this->validateEnum($mapping['input_mode_condition'], self::VALID_INPUT_MODE_CONDITIONS, "button_mapping #{$index} input_mode_condition", $result);
                }
            }
        }
    }

    private function validateCustomRenderer(array $data, ValidationResult $result): void
    {
        if (!isset($data['renderer']) || $data['renderer'] === '') {
            $result->addError("Element of type 'custom' must have a 'renderer' defined.");
            return;
        }
        if (!in_array($data['renderer'], self::VALID_RENDERERS)) {
            $result->addWarning("Unknown renderer: '{$data['renderer']}'. Known renderers: " . implode(', ', self::VALID_RENDERERS));
        }
    }

    /**
     * Validates a bindings array.
     */
    private function validateBindings(array $bindings, ValidationResult $result): void
    {
        foreach ($bindings as $index => $binding) {
            if (!is_array($binding)) {
                $result->addError("Binding #{$index} must be an associative array.");
                continue;
            }

            // binding_type is optional in Bedrock UI (defaults to global)
            $type = $binding['binding_type'] ?? 'global';

            if (isset($binding['binding_type'])) {
                $this->validateEnum($binding['binding_type'], self::VALID_BINDING_TYPES, "binding #{$index} binding_type", $result);
            }

            if (isset($binding['binding_condition'])) {
                $this->validateEnum($binding['binding_condition'], self::VALID_BINDING_CONDITIONS, "binding #{$index} binding_condition", $result);
            }

            if ($type === 'global') {
                if (!isset($binding['binding_name']) || $binding['binding_name'] === '') {
                    $result->addError("Global binding #{$index} requires a 'binding_name'.");
                }
            }

            if ($type === 'view') {
                if (!isset($binding['source_property_name']) || $binding['source_property_name'] === '') {
                    $result->addError("View binding #{$index} requires a 'source_property_name'.");
                }
                if (!isset($binding['target_property_name']) || $binding['target_property_name'] === '') {
                    $result->addError("View binding #{$index} requires a 'target_property_name'.");
                }
            }

            if ($type === 'collection') {
                if (!isset($binding['binding_name']) || $binding['binding_name'] === '') {
                    $result->addError("Collection binding #{$index} requires a 'binding_name'.");
                }
                if (!isset($binding['binding_collection_name']) || $binding['binding_collection_name'] === '') {
                    $result->addError("Collection binding #{$index} requires a 'binding_collection_name'.");
                }
            }

            if ($type === 'collection_details') {
                if (!isset($binding['binding_collection_name']) || $binding['binding_collection_name'] === '') {
                    $result->addError("collection_details binding #{$index} requires a 'binding_collection_name'.");
                }
            }
        }
    }

    /**
     * Validates a variables array.
     */
    private function validateVariables(array $variables, ValidationResult $result): void
    {
        foreach ($variables as $index => $variable) {
            if (!is_array($variable)) {
                $result->addError("Variable #{$index} must be an associative array.");
                continue;
            }
            if (!isset($variable['requires']) || $variable['requires'] === '') {
                $result->addError("Variable #{$index} requires a 'requires' field (condition).");
            }
            $keys = array_keys($variable);
            $valueKeys = array_filter($keys, fn($k) => $k !== 'requires');
            if (empty($valueKeys)) {
                $result->addWarning("Variable #{$index} has no values defined besides 'requires'.");
            }
        }
    }

    /**
     * Validates child controls array.
     */
    private function validateControls(array $controls, ValidationResult $result): void
    {
        foreach ($controls as $index => $control) {
            if (!is_array($control)) {
                $result->addError("Child control #{$index} must be an array.");
                continue;
            }

            // Each control is an associative array { "name@extend": { ... } }
            foreach ($control as $childKey => $childData) {
                if (!is_array($childData)) continue;
                if (isset($childData['type'])) {
                    $childResult = new ValidationResult($this->extractElementName($childKey));
                    $this->validateElement($childKey, $childData, $childResult);
                    $result->merge($childResult);
                }
            }
        }
    }

    /**
     * Validates an animation.
     */
    private function validateAnimation(array $data, ValidationResult $result): void
    {
        if (!isset($data['anim_type'])) {
            $result->addError("Animation requires an 'anim_type'.");
            return;
        }

        $this->validateEnum($data['anim_type'], self::VALID_ANIM_TYPES, 'anim_type', $result);

        if (isset($data['easing'])) {
            $this->validateEnum($data['easing'], self::VALID_EASINGS, 'easing', $result);
        }

        if (isset($data['duration'])) {
            if (!is_numeric($data['duration']) || $data['duration'] < 0) {
                $result->addError("Property 'duration' must be a non-negative number.");
            }
        }

        if (isset($data['delay'])) {
            if (!is_numeric($data['delay']) || $data['delay'] < 0) {
                $result->addError("Property 'delay' must be a non-negative number.");
            }
        }

        $animType = $data['anim_type'];

        if (in_array($animType, ['alpha', 'clip'])) {
            if (isset($data['from']) && !is_numeric($data['from'])) {
                $result->addError("For '{$animType}' animation, 'from' must be a number.");
            }
            if (isset($data['to']) && !is_numeric($data['to'])) {
                $result->addError("For '{$animType}' animation, 'to' must be a number.");
            }
        }

        if (in_array($animType, ['offset', 'size', 'uv'])) {
            if (isset($data['from']) && (!is_array($data['from']) || count($data['from']) !== 2)) {
                $result->addError("For '{$animType}' animation, 'from' must be an array [x, y].");
            }
            if (isset($data['to']) && (!is_array($data['to']) || count($data['to']) !== 2)) {
                $result->addError("For '{$animType}' animation, 'to' must be an array [x, y].");
            }
        }

        if (in_array($animType, ['color'])) {
            if (isset($data['from']) && (!is_array($data['from']) || count($data['from']) < 3)) {
                $result->addError("For 'color' animation, 'from' must be an array [r, g, b] or [r, g, b, a].");
            }
            if (isset($data['to']) && (!is_array($data['to']) || count($data['to']) < 3)) {
                $result->addError("For 'color' animation, 'to' must be an array [r, g, b] or [r, g, b, a].");
            }
        }

        if (in_array($animType, ['flip_book', 'aseprite_flip_book'])) {
            if (!isset($data['fps']) || !is_numeric($data['fps']) || $data['fps'] <= 0) {
                $result->addWarning("flip_book animation should have a positive 'fps' value.");
            }
        }
    }

    // ---- Validation utilities ----

    private function validateEnum($value, array $validValues, string $propertyName, ValidationResult $result): void
    {
        if (!in_array($value, $validValues)) {
            $result->addError("Invalid value '{$value}' for '{$propertyName}'. Valid values: " . implode(', ', $validValues));
        }
    }

    private function validateRange($value, float $min, float $max, string $propertyName, ValidationResult $result): void
    {
        if (!is_numeric($value)) {
            $result->addError("Property '{$propertyName}' must be a number.");
            return;
        }
        if ($value < $min || $value > $max) {
            $result->addWarning("Property '{$propertyName}' is {$value}, expected between {$min} and {$max}.");
        }
    }

    private function validateSize($size, ValidationResult $result): void
    {
        if (!is_array($size)) {
            $result->addError("Property 'size' must be an array.");
            return;
        }
        if (count($size) !== 2) {
            $result->addError("Property 'size' must contain exactly 2 values.");
            return;
        }
        foreach ($size as $i => $val) {
            if (!is_numeric($val) && !is_string($val)) {
                $result->addError("Value of 'size[{$i}]' must be a number or a string (e.g. '100%', 'fill').");
            }
            if (is_string($val) && $val !== 'fill' && $val !== 'default'
                && !preg_match('/^\d+(\.\d+)?%?$/', $val)
                && !preg_match('/^\d+(\.\d+)?(px)?$/', $val)
                && !preg_match('/^\d+(\.\d+)?%[cxy]?$/', $val)
                && !preg_match('/^(fill|\d+(\.\d+)?(%( [+-] \d+(\.\d+)?px)?)?|(\d+(\.\d+)?px))$/', $val)
                && !preg_match('/^\d+%\s*[+-]\s*\d+px$/', $val)
                && !preg_match('/^(100|[1-9]?\d)%\s*-\s*\d+px$/', $val)
            ) {
                // Too many valid formats in Bedrock, only warn in strict mode
                if ($this->strictMode) {
                    $result->addWarning("Potentially invalid size format for 'size[{$i}]': '{$val}'.");
                }
            }
        }
    }

    private function validateOffset($offset, ValidationResult $result): void
    {
        if (!is_array($offset)) {
            $result->addError("Property 'offset' must be an array.");
            return;
        }
        if (count($offset) !== 2) {
            $result->addError("Property 'offset' must contain exactly 2 values [x, y].");
        }
    }

    private function validateColor(array $color, ValidationResult $result): void
    {
        if (count($color) < 3 || count($color) > 4) {
            $result->addError("Property 'color' must contain 3 (RGB) or 4 (RGBA) values.");
            return;
        }
        foreach ($color as $i => $component) {
            if (!is_numeric($component)) {
                $result->addError("Color component [{$i}] must be a number.");
            } elseif ($component < 0.0 || $component > 1.0) {
                $result->addWarning("Color component [{$i}] is {$component}, expected between 0.0 and 1.0.");
            }
        }
    }

    private function extractElementName(string $key): string
    {
        $parts = explode('@', $key);
        return $parts[0];
    }
}
