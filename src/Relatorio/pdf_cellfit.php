<?php

namespace MoneyLender\Src\Relatorio;
trait pdf_cellfit {

	function CellFit(
		$w,
		$h = 0,
		$txt = '',
		$border = 0,
		$ln = 0,
		$align = '',
		$fill = false,
		$link = '',
		$scale = false,
		$force = true
	): void {
		// Get string width
		$str_width = $this->GetStringWidth($txt);
		if ($str_width == 0) {
			$str_width = 1;
		}

		// Calculate ratio to fit cell
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$ratio = ($w - $this->cMargin * 2) / $str_width;

		$fit = ($ratio < 1 || ($ratio > 1 && $force));

		$this->preventFontReplace($h);

		if ($fit) {
			if ($scale) {
				// Calculate horizontal scaling
				$horiz_scale = $ratio * 100.0;
				// Set horizontal scaling
				$this->_out(sprintf('BT %.2F Tz ET', $horiz_scale));
			} else {
				// Calculate character spacing in points
				$char_space = ($w - $this->cMargin * 2 - $str_width) / max($this->MBGetStringLength($txt) - 1, 1) * $this->k;
				// Set character spacing
				$this->_out(sprintf('BT %.2F Tc ET', $char_space));
			}
			// Override user alignment (since text will fill up cell)
			$align = '';
		}

		// Pass on to Cell method
		$this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);

		// Reset character spacing/horizontal scaling
		if ($fit)
			$this->_out('BT ' . ($scale ? '100 Tz' : '0 Tc') . ' ET');
	}

	function preventFontReplace($h): void {
		$k = $this->k;
		if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
			// Automatic page break
			$x = $this->x;
			$ws = $this->ws;
			if ($ws > 0) {
				$this->ws = 0;
				$this->_out('0 Tw');
			}
			$this->AddPage($this->CurOrientation);
			$this->x = $x;
			if ($ws > 0) {
				$this->ws = $ws;
				$this->_out(sprintf('%.3F Tw', $ws * $k));
			}
		}
	}

	function CellFitScale($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = ''): void {
		$this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, true, false);
	}

	function MBGetStringLength($s):int {
		if ($this->CurrentFont ['type'] == 'Type0') {
			$len = 0;
			$nbbytes = strlen($s);
			for ($i = 0; $i < $nbbytes; $i++) {
				if (ord($s [$i]) < 128)
					$len++;
				else {
					$len++;
					$i++;
				}
			}
			return $len;
		} else
			return strlen($s);
	}
}