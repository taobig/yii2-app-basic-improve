FROM taobig/nginx-php72
# Ubuntu only

ARG env_name
ARG env_memory_limit
ARG env_schedule_file

ADD ${env_schedule_file} /tmp/schedule.cron


RUN echo "env.name=${env_name}" >> /usr/local/php/etc/php.ini
RUN sed -i "s/^memory_limit = 128M/memory_limit = ${env_memory_limit}/" /usr/local/php/etc/php.ini

RUN crontab /tmp/schedule.cron

ENTRYPOINT ["cron", "-f"]
