#!/bin/bash

# 请将本文件放在项目根目录！！！

#任务列表
Tasks=(task/a  )

# 配置基本目录
RootPath=$(cd `dirname $0`; pwd)
LogPath=${RootPath}/log
if [ ! -d ${LogPath} ]
then
mkdir ${LogPath}
fi
#echo $RootPath
#开始循环执行任务
for task in ${Tasks[@]};do
taskPath=${LogPath}/${task//\//_}
if [ ! -d ${taskPath} ]
then
mkdir ${taskPath}
fi
currentPath=${taskPath}/$(date +"%Y%m")
if [ ! -d ${currentPath} ]
then
mkdir ${currentPath}
fi
${RootPath}/yii2/yii ${task} >> ${currentPath}/run.log 2>${currentPath}/error.log &
done

exit 1
