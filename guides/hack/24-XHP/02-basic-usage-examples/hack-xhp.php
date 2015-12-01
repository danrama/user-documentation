<?hh

require __DIR__ . "/../../../../vendor/autoload.php";

function basic_usage_examples_get_string(): string {
  return "Hello";
}

function basic_usage_examples_get_float(): float {
  return 1.2;
}

function basic_usage_examples_embed_hack(): void {
  $xhp_float = <i>{basic_usage_examples_get_float()}</i>;
  $a = new MyBasicUsageExampleClass();

  echo (
    <div>
      {(new MyBasicUsageExampleClass())->getInt()}
      <strong>{basic_usage_examples_get_string()}</strong>
      {$xhp_float /* this embeds the <i /> element as a child of the <div /> */}
    </div>
  );
}

basic_usage_examples_embed_hack();
