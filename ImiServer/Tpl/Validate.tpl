<?php declare(strict_types=1);
echo '<?php'; ?>

declare(strict_types=1);

namespace <?php echo $namespace; ?>;

use Phpben\Imi\Validate\Validate;

class <?php echo $class; ?> extends Validate
{
    protected $rule = [
<?php
echo "\t\t"."'".$pri."' => 'require|integer',"."\n";
?>
<?php
if($sort){
echo "\t\t"."'changeid' => 'require|integer',"."\n";
echo "\t\t"."'pid' => 'require|integer',"."\n";
echo "\t\t"."'ids' => 'require',"."\n";
echo "\t\t"."'changepid' => '',"."\n";
}
?>
<?php
foreach ($columns as $k => $v) echo "\t\t"."'".$k."' => '".$v."',"."\n";
?>
    ];

    protected $message = [
    ];

    protected $scene = [
        'create' => [<?php foreach ($columns as $k => $v) echo "'".$k."', "; ?>],
        'update' => [<?php echo "'".$pri."'"; ?>, <?php foreach ($columns as $k => $v) echo "'".$k."', "; ?>],
        <?php if($sort){ ?>'sort' => ['ids','pid','changeid','changepid']<?php } ?>
        <?php echo "\n"; ?>
    ];
}
