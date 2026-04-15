<?php

namespace refaltor\ui\validators;

class ValidationResult
{
    private array $errors = [];
    private array $warnings = [];
    private string $context = '';

    public function __construct(string $context = '')
    {
        $this->context = $context;
    }

    public function addError(string $message): self
    {
        $this->errors[] = $this->context !== '' ? "[{$this->context}] {$message}" : $message;
        return $this;
    }

    public function addWarning(string $message): self
    {
        $this->warnings[] = $this->context !== '' ? "[{$this->context}] {$message}" : $message;
        return $this;
    }

    public function merge(ValidationResult $other): self
    {
        $this->errors = array_merge($this->errors, $other->getErrors());
        $this->warnings = array_merge($this->warnings, $other->getWarnings());
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function hasWarnings(): bool
    {
        return !empty($this->warnings);
    }

    public function isValid(): bool
    {
        return !$this->hasErrors();
    }

    public function getErrorCount(): int
    {
        return count($this->errors);
    }

    public function getWarningCount(): int
    {
        return count($this->warnings);
    }
}
