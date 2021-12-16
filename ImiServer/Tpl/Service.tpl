<?php declare(strict_types=1);
echo '<?php'; ?>

declare(strict_types=1);

namespace <?php echo $namespace; ?>;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;
use Imi\Aop\Annotation\Inject;
use ImiApp\ImiServer\Exception\ServiceException;
use <?php echo $model; ?> as Model;

/**
 * @Inherit
 * @Bean("<?php echo $service; ?>")
 */
class <?php echo $class; ?> extends AbstractService
{
    /**
     * @var string
     */
    public $model = Model::class;

}