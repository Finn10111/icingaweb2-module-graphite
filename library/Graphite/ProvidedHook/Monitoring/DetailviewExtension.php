<?php

namespace Icinga\Module\Graphite\ProvidedHook\Monitoring;

use Icinga\Module\Graphite\Web\Controller\TimeRangePickerTrait;
use Icinga\Module\Graphite\Web\Widget\Graphs;
use Icinga\Module\Monitoring\Hook\DetailviewExtensionHook;
use Icinga\Module\Monitoring\Object\MonitoredObject;

class DetailviewExtension extends DetailviewExtensionHook
{
    use TimeRangePickerTrait;

    public function getHtmlForObject(MonitoredObject $object)
    {
        $graphs = (string) Graphs::forMonitoredObject($object)
            ->setWidth(440)
            ->setHeight(220)
            ->setClasses(['monitored-object-detail-view'])
            ->setMaxVisibleGraphs(2)
            ->setPreloadDummy()
            ->setShowNoGraphsFound(false)
            ->handleRequest();

        if ($graphs !== '') {
            $this->handleTimeRangePickerRequest();
            return '<h2>' . mt('graphite', 'Graphs') . '</h2>'
                . $this->renderTimeRangePicker($this->getView()) . $graphs;
        }

        return '';
    }
}
