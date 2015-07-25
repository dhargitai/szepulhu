<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Form\Type;

use IntlDateFormatter;
use Locale;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Class DateType
 *
 * This class extends Symfony's DateType to expose the format string for the view layer by the "date_pattern" variable.
 * The purpose is to let the fronted know the expected date format.
 *
 * @package Application\Form\Type
 * @author Geza Buza <bghome@gmail.com>
 */
class DateType extends \Symfony\Component\Form\Extension\Core\Type\DateType
{
    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        parent::finishView($view, $form, $options);

        $dateFormat = is_int($options['format']) ? $options['format'] : self::DEFAULT_FORMAT;

        $formatter = new IntlDateFormatter(
            Locale::getDefault(),
            $dateFormat,
            IntlDateFormatter::NONE
        );

        $view->vars['date_pattern'] = $formatter->getPattern();
    }
}
