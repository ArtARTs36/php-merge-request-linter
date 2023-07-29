<?php

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffFragment;
use ArtARTs36\MergeRequestLinter\Domain\Request\DiffType;
use ArtARTs36\Str\Str;

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
            new DiffFragment(
                DiffType::NOT_CHANGES,
                Str::make(
                    '
@@ -48,3 +48,5 @@ Thumbs.db
 *.mov
 *.wmv
 ',
                )
            ),
            new DiffFragment(
                DiffType::NEW,
                Str::make('
/vendor/')
            ),
        ],
        '.mr-linter.yml' => [
            new DiffFragment(
                DiffType::NOT_CHANGES,
                Str::make('
@@ -0,0 +1,14 @@'),
            ),
            new DiffFragment(
                DiffType::NEW,
                Str::make('rules:
  "@mr-linter/has_any_labels_of":
    labels:
      - Feature
      - Bug
      - Docs
      - Tests
      - Optimization'),
            ),
            new DiffFragment(
                DiffType::OLD,
                Str::make('      - Removed_label'),
            ),
            new DiffFragment(
                DiffType::NEW,
                Str::make('
credentials:
  bitbucket_pipelines:
    app_password:
      user: aukrainsky
      password: "env(MR_LINTER_TOKEN)"'),
            ),
        ],
    ],
];
