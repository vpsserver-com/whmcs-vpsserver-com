<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * FileBagTest.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Bulat Shakirzyanov <mallluhuct@gmail.com>
 */
class FileBagTest extends TestCase
{
    public function testFileMustBeAnArrayOrUploadedFile()
    {
        $this->expectException('InvalidArgumentException');
        new FileBag(['file' => 'foo']);
    }

    public function testShouldConvertsUploadedFiles()
    {
        $tmpFile = $this->createTempFile();
        $file = new UploadedFile($tmpFile, basename($tmpFile), 'text/plain', 100, 0);

        $bag = new FileBag(['file' => [
            'name' => basename($tmpFile),
            'type' => 'text/plain',
            'tmp_name' => $tmpFile,
            'error' => 0,
            'size' => 100,
        ]]);

        $this->assertEquals($file, $bag->get('file'));
    }

    public function testShouldSetEmptyUploadedFilesToNull()
    {
        $bag = new FileBag(['file' => [
            'name' => '',
            'type' => '',
            'tmp_name' => '',
            'error' => UPLOAD_ERR_NO_FILE,
            'size' => 0,
        ]]);

        $this->assertNull($bag->get('file'));
    }

    public function testShouldRemoveEmptyUploadedFilesForMultiUpload()
    {
        $bag = new FileBag(['files' => [
            'name' => [''],
            'type' => [''],
            'tmp_name' => [''],
            'error' => [UPLOAD_ERR_NO_FILE],
            'size' => [0],
        ]]);

        $this->assertSame([], $bag->get('files'));
    }

    public function testShouldNotRemoveEmptyUploadedFilesForAssociativeArray()
    {
        $bag = new FileBag(['files' => [
            'name' => ['cloud-init.yaml' => ''],
            'type' => ['cloud-init.yaml' => ''],
            'tmp_name' => ['cloud-init.yaml' => ''],
            'error' => ['cloud-init.yaml' => UPLOAD_ERR_NO_FILE],
            'size' => ['cloud-init.yaml' => 0],
        ]]);

        $this->assertSame(['cloud-init.yaml' => null], $bag->get('files'));
    }

    public function testShouldConvertUploadedFilesWithPhpBug()
    {
        $tmpFile = $this->createTempFile();
        $file = new UploadedFile($tmpFile, basename($tmpFile), 'text/plain', 100, 0);

        $bag = new FileBag([
            'child' => [
                'name' => [
                    'file' => basename($tmpFile),
                ],
                'type' => [
                    'file' => 'text/plain',
                ],
                'tmp_name' => [
                    'file' => $tmpFile,
                ],
                'error' => [
                    'file' => 0,
                ],
                'size' => [
                    'file' => 100,
                ],
            ],
        ]);

        $files = $bag->all();
        $this->assertEquals($file, $files['child']['file']);
    }

    public function testShouldConvertNestedUploadedFilesWithPhpBug()
    {
        $tmpFile = $this->createTempFile();
        $file = new UploadedFile($tmpFile, basename($tmpFile), 'text/plain', 100, 0);

        $bag = new FileBag([
            'child' => [
                'name' => [
                    'sub' => ['file' => basename($tmpFile)],
                ],
                'type' => [
                    'sub' => ['file' => 'text/plain'],
                ],
                'tmp_name' => [
                    'sub' => ['file' => $tmpFile],
                ],
                'error' => [
                    'sub' => ['file' => 0],
                ],
                'size' => [
                    'sub' => ['file' => 100],
                ],
            ],
        ]);

        $files = $bag->all();
        $this->assertEquals($file, $files['child']['sub']['file']);
    }

    public function testShouldNotConvertNestedUploadedFiles()
    {
        $tmpFile = $this->createTempFile();
        $file = new UploadedFile($tmpFile, basename($tmpFile), 'text/plain', 100, 0);
        $bag = new FileBag(['image' => ['file' => $file]]);

        $files = $bag->all();
        $this->assertEquals($file, $files['image']['file']);
    }

    protected function createTempFile()
    {
        return tempnam(sys_get_temp_dir().'/form_test', 'FormTest');
    }

    protected function setUp()
    {
        mkdir(sys_get_temp_dir().'/form_test', 0777, true);
    }

    protected function tearDown()
    {
        foreach (glob(sys_get_temp_dir().'/form_test/*') as $file) {
            unlink($file);
        }

        rmdir(sys_get_temp_dir().'/form_test');
    }
}
