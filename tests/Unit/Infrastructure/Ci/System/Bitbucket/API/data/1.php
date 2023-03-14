<?php

return [
    'diff --git a/.gitignore b/.gitignore
index b24d71e..0da6934 100644
--- a/.gitignore
+++ b/.gitignore
@@ -48,3 +48,5 @@ Thumbs.db
 *.mov
 *.wmv
 
+
+/vendor/
diff --git a/.mr-linter.yml b/.mr-linter.yml
new file mode 100644
index 0000000..c66bfc1
--- /dev/null
+++ b/.mr-linter.yml
@@ -0,0 +1,14 @@
+rules:
+  "@mr-linter/has_any_labels_of":
+    labels:
+      - Feature
+      - Bug
+      - Docs
+      - Tests
+      - Optimization
-      - Removed_label
+
+credentials:
+  bitbucket_pipelines:
+    app_password:
+      user: aukrainsky
+      password: "env(MR_LINTER_TOKEN)"',
    [
        '.gitignore' => [
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NOT_CHANGES,
                \ArtARTs36\Str\Str::make(''),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NOT_CHANGES,
                \ArtARTs36\Str\Str::make('@@ -48,3 +48,5 @@ Thumbs.db'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NOT_CHANGES,
                \ArtARTs36\Str\Str::make(' *.mov'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NOT_CHANGES,
                \ArtARTs36\Str\Str::make(' *.wmv'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NOT_CHANGES,
                \ArtARTs36\Str\Str::make(' '),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make(''),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('/vendor/'),
            ),
        ],
        '.mr-linter.yml' => [
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NOT_CHANGES,
                \ArtARTs36\Str\Str::make(''),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NOT_CHANGES,
                \ArtARTs36\Str\Str::make('@@ -0,0 +1,14 @@'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('rules:'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('  "@mr-linter/has_any_labels_of":'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('    labels:'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('      - Feature'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('      - Bug'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('      - Docs'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('      - Tests'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('      - Optimization'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::OLD,
                \ArtARTs36\Str\Str::make('      - Removed_label'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make(''),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('credentials:'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('  bitbucket_pipelines:'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('    app_password:'),
            ),
            new \ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine(
                \ArtARTs36\MergeRequestLinter\Domain\Request\DiffType::NEW,
                \ArtARTs36\Str\Str::make('      user: aukrainsky'),
            ),
        ],
    ],
];
