<?php
declare(strict_types=1);

namespace TimeDiff;

use DateTimeImmutable;
use DateTimeInterface;

use function _;
use function sprintf;

class TimeDiff
{
    private readonly DateTimeInterface $to;

    public function __construct(
        private readonly DateTimeInterface $from,
        DateTimeInterface $to = null,
    ) {
        if ($to === null) {
            $this->to = new DateTimeImmutable();
        } else {
            $this->to = $to;
        }
    }

    public function humanReadableShort(bool $withSeconds = false): string
    {
        $interval = $this->from->diff($this->to);
        if ($interval->invert === 1) {
            return _('now');
        }

        if ($interval->y > 0) {
            if ($interval->m === 0) {
                // TRANSLATORS: %d years, e.g. "1 y" as in "1 year"
                return sprintf(_('%d y'), $interval->y);
            }

            // TRANSLATORS: %d months, e.g. "1 mo" as in "1 month"
            return sprintf(_('%d y') . ' ' . _('%d mo'), $interval->y, $interval->m);
        }

        if ($interval->m > 0) {
            // TRANSLATORS: %d months, e.g. "1 mo" as in "1 month"
            return sprintf(_('%d mo'), $interval->m);
        }

        if ($interval->d > 0) {
            // TRANSLATORS: %d days, e.g. "1 d" as in "1 day"
            return sprintf(_('%d d'), $interval->d);
        }

        if ($interval->h > 0) {
            // TRANSLATORS: %d hours, e.g. "1 h" as in "1 hour"
            return sprintf(_('%d h'), $interval->h);
        }

        if ($interval->i > 0) {
            // TRANSLATORS: %d minutes, e.g. "1 min" as in "1 minute"
            return sprintf(_('%d min'), $interval->i);
        }

        if ($withSeconds && $interval->s > 0) {
            // TRANSLATORS: %d seconds, e.g. "1 s" as in "1 second"
            return sprintf(_('%d s'), $interval->s);
        }

        return _('now');
    }
}